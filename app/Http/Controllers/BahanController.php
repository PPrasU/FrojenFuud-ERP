<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bahan;
use Barryvdh\Snappy\Facades\SnappyPdf;

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
        return redirect()->route('Bahan')->with('Success', 'Data Bahan Berhasil Diperbarui');
    }

    public function hapusBahan($id){
        $data = Bahan::find($id);
        $data->delete();
        return redirect()->route('Bahan')->with('Success', 'Data Bahan Berhasil Dihapus');
    }

    public function exportBahan(Request $request){
        $selectedItems = $request->input('items');

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Tidak ada bahan yang dipilih');
        }

        $data = Bahan::whereIn('id', $selectedItems)->get();

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
        
        $pdf = SnappyPdf::loadView('export.exportBahan', compact('data'))
                        ->setOptions($options)
                        ->setPaper('a4', 'landscape');
        


        $dateTime = date('d-m-Y  h:i:s');
        $fileName = "Laporan Bahan - {$dateTime}.pdf";
        
        return $pdf->download($fileName);
    }
}
