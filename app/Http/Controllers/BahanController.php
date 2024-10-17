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
        // Ambil ID item yang dipilih dari form
        $selectedItems = $request->input('items');

        // Jika tidak ada data yang dipilih
        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Tidak ada bahan yang dipilih');
        }

        // Ambil data bahan berdasarkan ID yang dipilih
        $data = Bahan::whereIn('id', $selectedItems)->get();

        // Jika data kosong
        if ($data->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Generate PDF dengan view 'exportBahan'
        $pdf = Pdf::loadView('export.exportBahan', compact('data'))
                    ->setPaper('a4', 'landscape');

        // Format nama file PDF dengan waktu saat ini
        $dateTime = date('d-m-Y  H:i:s');
        $fileName = "Laporan Bahan - {$dateTime}.pdf";

        // Unduh file PDF
        return $pdf->download($fileName);
    }
}
