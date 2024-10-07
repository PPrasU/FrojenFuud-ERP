<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bahan;
use Barryvdh\DomPDF\Facade\Pdf;

class BahanController extends Controller
{
    public function Bahan(){
        $data = Bahan::all();
        return view('product.bahan', compact('data')); 
    }

    public function inputBahan(){
        return view('product.inputBahan');
    }

    public function postBahan(Request $request){
        //dd($request->all());
        $data = Bahan::create($request->all());
        if($request->hasFile('gambar')){
            $request->file('gambar')->move('foto-Bahan/', $request->file('gambar')->getClientOriginalName());
            $data->gambar = $request->file('gambar')->getClientOriginalName();
            $data->save();
        }
        return redirect()->route('Bahan')->with('Success', 'Data Bahan Berhasil Ditambahkan');
    }

    public function editBahan($id){
        $data = Bahan::find($id);
        return view('product.editBahan', compact('data'));
    }

    public function updateBahan(Request $request, $id ){
        $data = Bahan::find($id);
        $data->update($request->all());
        return redirect()->route('Bahan')->with('Success', 'Data Bahan Berhasil Diperbarui');
    }

    public function hapusBahan($id){
        $data = Bahan::find($id);
        $data->delete();
        return redirect()->route('Bahan')->with('Success', 'Data Bahan Berhasil Dihapus');
    }

    public function exportBahan(){
        $data = Bahan::all();
        $pdf = pdf::loadView('export.exportBahan', compact('data'));
        $dateTime = date('d-m-Y_H:i:s');
    
        // Menyusun nama file PDF dengan format yang diinginkan
        $fileName = "{$dateTime}_Laporan Bahan.pdf";
    
        // Mengunduh file PDF dengan nama yang telah disusun
        return $pdf->download($fileName);
    }
}
