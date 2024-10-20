<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BillOfMaterial;
use App\Models\BillOfMaterialBahan;
use App\Models\Produk;
use App\Models\Bahan;

use Barryvdh\Snappy\Facades\SnappyPdf;

class BillOfMaterialController extends Controller
{
    public function BillOfMaterial(){
        $data = BillOfMaterial::all();
        return view('manufacturing.billOfMaterial', compact('data')); 
    }

    public function inputBillOfMaterial(){
        $produk = Produk::all();
        $bahan = Bahan::all();
        return view('manufacturing.inputBillOfMaterial', compact('produk', 'bahan'));
    }

    public function postBillOfMaterial(Request $request){
        $billOfMaterial = BillOfMaterial::create([
            'produk_id' => $request->produk_id,
            'reference' => $request->reference,
            'kuantitas_produk' => $request->kuantitas_produk,
            'variasi' => $request->variasi,
        ]);
    
        $bahan_ids = $request->input('bahan_id');
        $kuantitas = $request->input('kuantitas');
        $satuan = $request->input('satuan');
    
        for ($i = 0; $i < count($bahan_ids); $i++) {
            $billOfMaterial->bahans()->attach($bahan_ids[$i], [
                'kuantitas' => $kuantitas[$i],
                'satuan' => $satuan[$i],
            ]);
        }

        return redirect()->route('BillOfMaterial')->with('Success', 'Data BoM Berhasil Ditambahkan');
    }

    public function editBillOfMaterial($id){
        $produk = Produk::all();
        $bahan = Bahan::all();
        $bill_of_material_bahan = 
        $data = BillOfMaterial::find($id);
        return view('manufacturing.editBillOfMaterial', compact('data', 'produk', 'bahan'));
    }

    public function updateBillOfMaterial(Request $request, $id ){
        $data = BillOfMaterial::find($id);
        
        // Update data utama
        $data->update($request->only(['produk_id', 'reference', 'variasi', 'kuantitas_produk']));

        // Update data pivot (hapus yang lama, simpan yang baru)
        $data->bahans()->detach(); // Hapus relasi lama
        foreach ($request->bahan_ids as $index => $bahan_id) {
            $data->bahans()->attach($bahan_id, [
                'kuantitas_bahan' => $request->kuantitas_bahan[$index],
                'satuan_bahan' => $request->satuan_bahan[$index],
            ]);
        }

        return redirect()->route('BillOfMaterial')->with('Success', 'Data BoM Berhasil Diperbarui');
    }

    public function hapusBillOfMaterial($id){
        $data = BillOfMaterial::find($id);
        $data->delete();
        return redirect()->route('BillOfMaterial')->with('Success', 'Data BoM Berhasil Dihapus');
    }

    public function exportBillOfMaterial(Request $request){
        $data = BillOfMaterial::all();

        $options = [
            'margin-top' => 10,
            'margin-right' => 10,
            'margin-bottom' => 10,
            'margin-left' => 10,
            'javascript-delay' => 500,
            'no-stop-slow-scripts' => true, 
            'disable-smart-shrinking' => true,
        ];

        $pdf = SnappyPdf::loadView('export.exportBillOfMaterial', compact('data'))
            ->setOptions($options)
            ->setPaper('a4', 'landscape');
        
        $dateTime = date('d-m-Y  h:i:s');
        $fileName = "Laporan BillOfMaterial - {$dateTime}.pdf";
        
        return $pdf->download($fileName);
    }

}
