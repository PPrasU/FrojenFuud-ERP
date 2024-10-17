<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use Barryvdh\Snappy\Facades\SnappyPdf;

class ProdukController extends Controller
{
    public function Produk(){
        $data = Produk::all();
        return view('product.produk', compact('data')); 
    }

    public function inputProduk(){
        return view('product.inputProduk');
    }

    public function postProduk(Request $request){
        //dd($request->all());
        $data = Produk::create($request->all());
        if($request->hasFile('gambar')){
            $request->file('gambar')->move('foto-produk/', $request->file('gambar')->getClientOriginalName());
            $data->gambar = $request->file('gambar')->getClientOriginalName();
            $data->save();
        }
        return redirect()->route('Produk')->with('Success', 'Data Produk Berhasil Ditambahkan');
    }

    public function editProduk($id){
        $data = Produk::find($id);
        return view('product.editProduk', compact('data'));
    }

    public function updateProduk(Request $request, $id ){
        $data = Produk::find($id);
        if($request->hasFile('gambar')){
            // Hapus gambar lama jika ada
            if ($data->gambar) {
                $oldImagePath = public_path('foto-Bahan/' . $data->gambar);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Hapus file lama
                }
            }

            // Pindahkan file gambar baru
            $newImageName = $request->file('gambar')->getClientOriginalName();
            $request->file('gambar')->move('foto-Bahan/', $newImageName);
            // Perbarui kolom gambar dengan nama file baru
            $data->gambar = $newImageName;
        }
        // Perbarui kolom lain (kecuali gambar)
        $data->update($request->except('gambar'));
        return redirect()->route('Produk')->with('Success', 'Data Produk Berhasil Diperbarui');
    }

    public function hapusProduk($id){
        $data = Produk::find($id);
        $data->delete();
        return redirect()->route('Produk')->with('Success', 'Data Produk Berhasil Dihapus');
    }

    public function exportProduk(Request $request){
        $selectedItems = $request->input('items');

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Tidak ada produk yang dipilih');
        }

        $data = Produk::whereIn('id', $selectedItems)->get();

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
        
        $pdf = SnappyPdf::loadView('export.exportProduk', compact('data'))
                        ->setOptions($options)
                        ->setPaper('a4', 'landscape');
        


        $dateTime = date('d-m-Y  h:i:s');
        $fileName = "Laporan Produk - {$dateTime}.pdf";
        
        return $pdf->download($fileName);
    }
}
