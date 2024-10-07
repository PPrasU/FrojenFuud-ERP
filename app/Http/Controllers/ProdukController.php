<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf;

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
        Produk::create($request->all());
        return redirect()->route('Produk')->with('Success', 'Data Produk Berhasil Ditambahkan');
    }

    public function editProduk($id){
        $data = Produk::find($id);
        return view('product.editProduk', compact('data'));
    }

    public function updateProduk(Request $request, $id ){
        $data = Produk::find($id);
        $data->update($request->all());
        return redirect()->route('Produk')->with('Success', 'Data Produk Berhasil Diperbarui');
    }

    public function hapusProduk($id){
        $data = Produk::find($id);
        $data->delete();
        return redirect()->route('Produk')->with('Success', 'Data Produk Berhasil Dihapus');
    }

    public function exportProduk(){
        $data = Produk::all();
        $pdf = pdf::loadView('export.exportProduk', compact('data'));
        $dateTime = date('d-m-Y_H:i:s');
    
        // Menyusun nama file PDF dengan format yang diinginkan
        $fileName = "{$dateTime}_Laporan Produk.pdf";
    
        // Mengunduh file PDF dengan nama yang telah disusun
        return $pdf->download($fileName);
    }
}
