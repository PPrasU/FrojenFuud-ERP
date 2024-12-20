<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\ManufacturingOrder;
use App\Models\ManufacturingOrderBahan;
use App\Models\Produk;
use App\Models\Bahan;
use App\Models\BillOfMaterialBahan;
use App\Models\BillOfMaterial;
use Illuminate\Support\Facades\DB;

use Barryvdh\Snappy\Facades\SnappyPdf;

class ManufacturingOrderController extends Controller
{
    public function ManufacturingOrder()
    {
        $data = ManufacturingOrder::with([
            'produk' => function ($query) {
                $query->orderBy('id', 'asc'); // Mengurutkan produk berdasarkan id
            }
        ])->orderBy('id', 'asc')->get();

        return view('MO.MO', compact('data'));
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Controller State Draft ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    public function draftManufacturingOrder()
    {
        $produks = Produk::all();
        $bill_of_materials = BillOfMaterial::all();
        $bill_of_material_bahans = BillOfMaterialBahan::all();
        $state = 0;
        return view('MO.proses.draftMO', compact('produks', 'bill_of_materials', 'bill_of_material_bahans', 'state'));
    }

    public function getBillOfMaterials($produk_id)
    {
        // Ambil data Bill Of Material yang terkait dengan produk_id yang dipilih
        $bill_of_materials = BillOfMaterial::where('produk_id', $produk_id)->get();

        // Kembalikan data Bill Of Material dalam format JSON
        return response()->json($bill_of_materials);
    }

    public function getBahanByBillOfMaterial($bill_of_material_id)
    {
        // Ambil data bahan terkait dengan bill_of_material_id
        $bahan = BillOfMaterialBahan::where('bill_of_material_id', $bill_of_material_id)->get();

        // Kembalikan data dalam format JSON
        return response()->json($bahan);
    }

    public function postdraftManufacturingOrder(Request $request)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'nama_produk' => 'required|exists:produks,id',
            'produkSelect' => 'required|exists:bill_of_materials,id',
            'quantity' => 'required|integer|min:1',
            'jadwal' => 'required|date',
            'harga_produk' => 'required|numeric|min:0', // Validasi harga produk
        ]);

        // Ambil data produk yang dipilih
        $produk = Produk::find($request->nama_produk);
        $productCode = strtoupper(substr($produk->kode_produk, 0, 2)); // Ambil 2 huruf pertama dari kode produk, misalnya "LA" untuk "Lumpia Ayam"

        // Ambil nama produk dari BillOfMaterial berdasarkan produkSelect
        $billOfMaterial = BillOfMaterial::find($request->produkSelect);
        $namaProdukBillOfMaterial = $billOfMaterial ? $billOfMaterial->nama_produk : null;

        // Hitung jumlah pembuatan MO untuk produk tersebut
        $count = ManufacturingOrder::where('nama_produk', $namaProdukBillOfMaterial)->count();

        // Generate kode referensi, misalnya: MO-LA-1, MO-LA-2
        $referenceCode = 'MO-' . $productCode . '-' . ($count + 1);

        // Simpan data ke dalam tabel `manufacturing_orders`
        $manufacturingOrder = ManufacturingOrder::create([
            'nama_produk' => $namaProdukBillOfMaterial,
            'produk_id' => $produk->id, // Simpan produk_id dari tabel `produks`
            'reference' => $referenceCode, // Referensi dihasilkan otomatis
            'bill_of_material_id' => $request->produkSelect,
            'quantity' => $request->quantity,
            'deadline' => $request->jadwal,
            'state' => 'draft',
            'harga_produk' => $request->harga_produk, // Simpan total harga dari input hidden
        ]);

        // Simpan bahan-bahan terkait di tabel `manufacturing_order_bahans`
        $billOfMaterialBahan = BillOfMaterialBahan::where('bill_of_material_id', $request->produkSelect)->get();

        foreach ($billOfMaterialBahan as $bahan) {
            ManufacturingOrderBahan::create([
                'manufacturing_order_id' => $manufacturingOrder->id,
                'nama_bahan' => $bahan->nama_bahan,
                'to_consume' => $bahan->kuantitas * $manufacturingOrder->quantity,
                'harga_bahan' => $bahan->harga_satuan,
                'state' => 'draft',
            ]);
        }

        return redirect()->route('ManufacturingOrder')->with('success', 'Manufacturing Order berhasil disimpan.');
    }




    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Controller State Confirmed ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public function confirmedMO($id)
    {
        $order = ManufacturingOrder::findOrFail($id);
        $produks = Produk::all();
        $bill_of_materials = BillOfMaterial::all(); // Ambil semua Bill of Material
        $bahanOrder = ManufacturingOrderBahan::with('bahan')->where('manufacturing_order_id', $id)->get();

        $order->state = 'confirmed';
        $order->save();

        $state = 1; // Nilai state untuk arrow progress
        return view('MO.proses.ConfirmedMO', compact('order', 'state', 'produks', 'bill_of_materials', 'bahanOrder'));
    }

    public function postConfirmedForm(Request $request, $id)
    {
        // Ambil data Manufacturing Order
        $order = ManufacturingOrder::findOrFail($id);

        // Ubah state menjadi confirmed
        $order->state = 'confirmed';
        $order->save();

        // Ambil kuantitas produk dari order
        $quantity = $order->quantity;

        // Ambil semua bahan terkait dengan order ini
        $bahanOrder = ManufacturingOrderBahan::where('manufacturing_order_id', $id)->get();

        // Perbarui quantity di tabel manufacturing_order_bahans
        foreach ($bahanOrder as $bahan) {
            $bahan->quantity;
            $bahan->save();
        }

        // Redirect ke halaman berikutnya (misal Check Availability)
        return redirect()->route('ManufacturingOrder');
    }

    public function getBahanByProduk($id)
    {
        $bahanOrder = ManufacturingOrderBahan::where('produk_id', $id)->get();
        $state = 1;
        return response()->json($bahanOrder);
    }



    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Controller State Check Availibility ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    public function checkAvailability($id)
    {
        $order = ManufacturingOrder::findOrFail($id);
        $produks = Produk::all();
        $bahanOrder = ManufacturingOrderBahan::where('manufacturing_order_id', $id)->get();

        $order->state = 'check_availability';
        $order->save();
        $state = 2;

        return view('MO.proses.checkMO', compact('order', 'bahanOrder', 'state', 'produks'));
    }

    public function postcheckAvailabilityForm(Request $request)
    {
        $validatedData = $request->validate([
            'nama_bahan' => 'required|array',
            'status_bahan' => 'required|array',
            'quantity_bahan' => 'required|array',
        ]);

        $namaBahan = $request->input('nama_bahan');
        $statusBahan = $request->input('status_bahan');
        $quantityBahan = $request->input('quantity_bahan');

        foreach ($namaBahan as $index => $bahan) {
            $status = $statusBahan[$index]; // Ambil status (1 atau 0)
            $toConsume = $quantityBahan[$index];

            // Simpan ke database
            ManufacturingOrderBahan::where('nama_bahan', $bahan)
                ->update([
                    'quantity' => $status, // Simpan status sebagai quantity
                ]);
        }

        return redirect()->route('ManufacturingOrder');
    }



    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Controller State Progress ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    public function progress($id)
    {
        $order = ManufacturingOrder::findOrFail($id);
        $produks = Produk::all();
        $bahanOrder = ManufacturingOrderBahan::where('manufacturing_order_id', $id)->get();

        $order->state = 'in_progress';
        $order->save();
        $state = 3;
        // Logika untuk memperbarui kuantitas dan centang di database
        return view('MO.proses.progressMO', compact('order', 'bahanOrder', 'state', 'produks'));
    }

    public function postprogressForm(Request $request, $id)
    {
        $processedBahan = [];
        // Ambil data Manufacturing Order berdasarkan ID
        $order = ManufacturingOrder::findOrFail($id);

        // Ambil semua bahan terkait Manufacturing Order
        $bahanOrders = ManufacturingOrderBahan::where('manufacturing_order_id', $id)->get();

        foreach ($bahanOrders as $bahanOrder) {
            if (in_array($bahanOrder->nama_bahan, $processedBahan)) {
                continue; // Skip bahan yang sudah diproses
            }
            $bahan = Bahan::where('nama_bahan', $bahanOrder->nama_bahan)->first();
            if ($bahan) {
                $bahan->kuantitas_bahan -= $bahanOrder->to_consume;
                if ($bahan->kuantitas_bahan < 0) {
                    $bahan->kuantitas_bahan = 0;
                }
                $bahan->save();
            }
            $processedBahan[] = $bahanOrder->nama_bahan; // Tandai bahan sudah diproses
        }

        // Update status Manufacturing Order jika diperlukan
        $order->save();

        // Redirect ke halaman Manufacturing Order dengan pesan sukses
        return redirect()->route('ManufacturingOrder')->with('success', 'Bahan berhasil dikurangi dan order diproses.');
    }



    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Controller State Done ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    public function done($id)
    {
        // Temukan Manufacturing Order berdasarkan ID
        $order = ManufacturingOrder::findOrFail($id);

        // Ambil produk terkait berdasarkan produk_id dari order
        $produk = Produk::find($order->produk_id);

        if ($produk) {
            // Tambahkan kuantitas_produk di tabel produks
            $produk->kuantitas_produk += $order->quantity;
            $produk->save(); // Simpan perubahan
        }

        // Update state menjadi 'done' pada Manufacturing Order
        $order->state = 'done';
        $order->save();

        // Data untuk halaman DoneMO
        $bahanOrder = ManufacturingOrderBahan::where('manufacturing_order_id', $id)->get();
        $produks = Produk::all();
        $state = 4;

        return view('MO.proses.DoneMO', compact('order', 'bahanOrder', 'state', 'produks'));
    }




    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Controller Umum ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    public function hapusMO($id)
    {
        // Temukan data di tabel ManufacturingOrder
        $data = ManufacturingOrder::find($id);

        if ($data) {
            // Hapus semua bahan terkait di tabel ManufacturingOrderBahan
            ManufacturingOrderBahan::where('manufacturing_order_id', $id)->delete();

            // Hapus data di tabel ManufacturingOrder
            $data->delete();

            // Reset auto-increment setelah menghapus data
            DB::statement('ALTER TABLE manufacturing_orders AUTO_INCREMENT = 1');
            DB::statement('ALTER TABLE manufacturing_order_bahans AUTO_INCREMENT = 1');

            return redirect()->route('ManufacturingOrder')->with('success', 'Data Manufacturing Order dan bahan terkait berhasil dihapus.');
        } else {
            return redirect()->route('ManufacturingOrder')->with('error', 'Data tidak ditemukan.');
        }
    }

    public function details()
    {
        return $this->hasMany(ManufacturingOrderBahan::class, 'manufacturing_order_id');
    }

    public function exportMO(Request $request)
    {
        $selectedItems = $request->input('items');

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Tidak ada produk yang dipilih');
        }

        $data = ManufacturingOrder::with('details')->whereIn('id', $selectedItems)->get();

        // foreach ($data as $mo) {
        //     // Perhitungan biaya
        //     $mo->total_unit_cost = $mo->details->sum('unit_cost');
        //     $mo->total_mo_cost = $mo->details->sum('mo_cost');
        //     $mo->total_product_cost = $mo->details->sum('real_cost'); // Real cost sama dengan product cost
        // }

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

        $pdf = SnappyPdf::loadView('export.exportMO', compact('data'))
            ->setOptions($options)
            ->setPaper('a4', 'landscape');

        $dateTime = date('d-m-Y  h:i:s');
        $fileName = "Laporan Manufacturing Order - {$dateTime}.pdf";

        return $pdf->download($fileName);
    }

}


