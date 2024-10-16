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
        // Ambil ID item yang dipilih dari form
        $selectedItems = $request->input('items');

        // Jika tidak ada data yang dipilih
        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Tidak ada produk yang dipilih');
        }

        // Ambil data produk berdasarkan ID yang dipilih
        $data = Produk::whereIn('id', $selectedItems)->get();

        // Jika data kosong
        if ($data->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Generate PDF dengan view 'exportProduk'
        $pdf = Pdf::loadView('export.exportProduk', compact('data'))
                    ->setPaper('a4', 'landscape');

        // Format nama file PDF dengan waktu saat ini
        $dateTime = date('d-m-Y');
        $fileName = "Laporan Produk - {$dateTime}.pdf";

        // Unduh file PDF
        return $pdf->download($fileName);
    }
}
