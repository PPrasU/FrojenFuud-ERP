<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\BillOfMaterial;
use App\Models\BillOfMaterialBahan;
use App\Models\Produk;
use App\Models\Bahan;

use Barryvdh\Snappy\Facades\SnappyPdf;

class BillOfMaterialController extends Controller
{
    public function BillOfMaterial()
    {
        $data = BillOfMaterial::all();
        return view('manufacturing.billOfMaterial', compact('data'));
    }

    public function inputBillOfMaterial()
    {
        $produk = Produk::all();
        $bahan = Bahan::all();
        return view('manufacturing.inputBillOfMaterial', compact('produk', 'bahan'));
    }

    public function postBillOfMaterial(Request $request)
    {
        // Validasi input
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'variasi' => 'nullable|string',
        ]);

        $produk = Produk::find($request->produk_id);
        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        // Ambil kode produk (contoh: LA, SM)
        $productCode = strtoupper($produk->kode_produk);

        // Hitung jumlah BoM sebelumnya dengan kode produk yang sama
        $count = BillOfMaterial::whereHas('produk', function ($query) use ($productCode) {
            $query->where('kode_produk', $productCode);
        })->count();

        // Generate kode referensi (BoM_LA_1, BoM_LA_2, dll.)
        $referenceCode = 'BoM_' . $productCode . '_' . ($count + 1);

        // Simpan data BoM ke database
        $billOfMaterial = BillOfMaterial::create([
            'produk_id' => $request->produk_id,
            'reference' => $referenceCode,
            'variasi' => $request->variasi,
            'nama_produk' => $produk->nama_produk,
        ]);

        // Proses bahan terkait
        $bahan_ids = $request->input('bahan_id');
        $kuantitas = $request->input('kuantitas');
        $satuan = $request->input('satuan');

        for ($i = 0; $i < count($bahan_ids); $i++) {
            $bahan = Bahan::find($bahan_ids[$i]); // Temukan data bahan berdasarkan ID
            if ($bahan) {
                // Hitung harga_satuan (kuantitas * harga_bahan)
                $hargaSatuan = $kuantitas[$i] * $bahan->harga_bahan;

                // Tambahkan ke tabel pivot, termasuk `nama_bahan` dan `harga_satuan`
                $billOfMaterial->bahans()->attach($bahan_ids[$i], [
                    'kuantitas' => $kuantitas[$i],
                    'satuan' => $satuan[$i],
                    'nama_bahan' => $bahan->nama_bahan, // Simpan `nama_bahan` di tabel pivot
                    'harga_satuan' => $hargaSatuan, // Simpan hasil perhitungan
                ]);
            }
        }

        return redirect()->route('BillOfMaterial')->with('Success', 'Data BoM Berhasil Ditambahkan dengan Referensi: ' . $referenceCode);
    }


    public function editBillOfMaterial($id)
    {
        // Ambil semua produk untuk dropdown produk
        $produk = Produk::all();

        // Ambil semua bahan untuk dropdown bahan
        $bahan = Bahan::all();

        // Ambil Bill of Material
        $data = BillOfMaterial::find($id);

        // Ambil bahan terkait dari tabel `bill_of_material_bahan`
        $bahanBoM = DB::table('bill_of_material_bahan')
            ->where('bill_of_material_id', $id)
            ->get();

        // Kirim data produk, bahan, BoM, dan bahan terkait ke view
        return view('manufacturing.editBillOfMaterial', compact('data', 'produk', 'bahan', 'bahanBoM'));
    }


    public function updateBillOfMaterial(Request $request, $id)
    {
        $data = BillOfMaterial::find($id);

        // Ambil nama produk terbaru berdasarkan produk_id yang dipilih
        $produk = Produk::find($request->produk_id);
        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        // Update data utama
        $data->update([
            'produk_id' => $request->produk_id,
            'reference' => $request->reference,
            'variasi' => $request->variasi,
            'nama_produk' => $produk->nama_produk,
        ]);

        // Hapus data bahan lama
        DB::table('bill_of_material_bahan')->where('bill_of_material_id', $id)->delete();

        // Simpan data bahan baru
        foreach ($request->bahan_id as $index => $bahan_id) {
            $kuantitas = isset($request->kuantitas[$index]) ? $request->kuantitas[$index] : null;
            $satuan = isset($request->satuan[$index]) ? $request->satuan[$index] : null;
            $harga_satuan = isset($request->harga_satuan[$index]) ? $request->harga_satuan[$index] : null;

            // Konversi harga_satuan ke float
            if ($harga_satuan !== null) {
                $harga_satuan = (float) str_replace(',', '.', str_replace('.', '', str_replace('Rp ', '', $harga_satuan)));
            }

            // Ambil nama bahan
            $bahan = Bahan::find($bahan_id);

            // Tambahkan ke tabel
            DB::table('bill_of_material_bahan')->insert([
                'bill_of_material_id' => $id,
                'bahan_id' => $bahan_id,
                'kuantitas' => $kuantitas,
                'satuan' => $satuan,
                'harga_satuan' => $harga_satuan,
                'nama_bahan' => $bahan ? $bahan->nama_bahan : null, // Pastikan nama bahan terisi
                'created_at' => now(), // Isi waktu sekarang
                'updated_at' => now(), // Isi waktu sekarang
            ]);
        }

        return redirect()->route('BillOfMaterial')->with('Success', 'Data BoM Berhasil Diperbarui');
    }




    public function hapusBillOfMaterial($id)
    {
        $data = BillOfMaterial::find($id);
        if ($data) {
            // Hapus semua bahan terkait di tabel ManufacturingOrderBahan
            BillOfMaterialBahan::where('bill_of_material_id', $id)->delete();

            // Hapus data di tabel ManufacturingOrder
            $data->delete();

            // Reset auto-increment setelah menghapus data
            DB::statement('ALTER TABLE bill_of_materials AUTO_INCREMENT = 1');
            DB::statement('ALTER TABLE bill_of_material_bahan AUTO_INCREMENT = 1');

            return redirect()->route('BillOfMaterial', compact('data'))->with('Success', 'Data BoM Berhasil Dihapus');
        } else {
            return redirect()->route('BillOfMaterial', compact('data'))->with('error', 'Data tidak ditemukan.');
        }
    }

    public function details()
    {
        return $this->hasMany(BillOfMaterialBahan::class, 'bill_of_material_id', 'id');
    }

    public function exportBillOfMaterial(Request $request)
    {
        $selectedItems = $request->input('items');

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Tidak ada produk yang dipilih');
        }

        $data = BillOfMaterial::with(['details.billofmaterialbahan'])->whereIn('id', $selectedItems)->get();

        foreach ($data as $bom) {
            foreach ($bom->details as $detail) {
                // Ambil harga_satuan dari relasi billofmaterialbahan
                $detail->bom_cost = $detail->billofmaterialbahan->harga_satuan ?? 0;
        
                // Product cost sama dengan bom_cost
                $detail->product_cost = $detail->bom_cost;
            }
        
            // Total cost untuk setiap BoM
            $bom->total_bom_cost = $bom->details->sum('bom_cost');
            $bom->total_product_cost = $bom->details->sum('product_cost');
        }

        if ($data->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $options = [
            'margin-top' => 10,
            'margin-right' => 10,
            'margin-bottom' => 10,
            'margin-left' => 10,
            'javascript-delay' => 500,
            'no-stop-slow-scripts' => true,
            'disable-smart-shrinking' => true,
        ];

        $pdf = SnappyPdf::loadView('export.exportBoM', compact('data'))
            ->setOptions($options)
            ->setPaper('a4', 'landscape');

        $dateTime = date('d-m-Y  h:i:s');
        $fileName = "Laporan Bill Of Material - {$dateTime}.pdf";

        return $pdf->download($fileName);
    }

}
