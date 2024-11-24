<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use Barryvdh\Snappy\Facades\SnappyPdf;

class VendorController extends Controller
{
    public function Vendor(){
        $data = Vendor::all();
        return view('purchasing.vendor', compact('data')); 
    }

    public function inputVendor(){
        return view('purchasing.inputVendor');
    }

    public function postVendor(Request $request){
        //dd($request->all());
        Vendor::create($request->all());
        return redirect()->route('Vendor')->with('Success', 'Data Vendor Berhasil Ditambahkan');
    }

    public function editVendor($id){
        $data = Vendor::find($id);
        return view('purchasing.editVendor', compact('data'));
    }

    public function updateVendor(Request $request, $id ){
        $data = Vendor::find($id);
        $data->update($request->all());
        return redirect()->route('Vendor')->with('Success', 'Data Vendor Berhasil Diperbarui');
    }

    public function hapusVendor($id){
        $data = Vendor::find($id);
        $data->delete();
        return redirect()->route('Vendor')->with('Success', 'Data Vendor Berhasil Dihapus');
    }

    public function exportVendor(Request $request){
        $selectedItems = $request->input('items');

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Tidak ada Vendor yang dipilih');
        }

        $data = Vendor::whereIn('id', $selectedItems)->get();

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
        
        $pdf = SnappyPdf::loadView('export.exportVendor', compact('data'))
                        ->setOptions($options)
                        ->setPaper('a4', 'landscape');
        


        $dateTime = date('d-m-Y  h:i:s');
        $fileName = "Laporan Vendor - {$dateTime}.pdf";
        
        return $pdf->download($fileName);
    }
}
