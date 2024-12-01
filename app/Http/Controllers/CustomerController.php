<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\Snappy\Facades\SnappyPdf;

class CustomerController extends Controller
{
    public function Customer(){
        $data = Customer::all();
        return view('Sales.customer', compact('data')); 
    }

    public function inputCustomer(){
        $data = Customer::all();
        return view('Sales.inputCustomer', compact('data'));
    }

    public function postCustomer(Request $request){
        //dd($request->all());
        Customer::create($request->all());
        return redirect()->route('Customer')->with('Success', 'Data Customer Berhasil Ditambahkan');
    }

    public function editCustomer($id){
        $data = Customer::find($id);
        return view('Sales.editCustomer', compact('data'));
    }

    public function updateCustomer(Request $request, $id ){
        $data = Customer::find($id);
        $data->update($request->all());
        return redirect()->route('Customer')->with('Success', 'Data Customer Berhasil Diperbarui');
    }

    public function hapusCustomer($id){
        $data = Customer::find($id);
        $data->delete();
        return redirect()->route('Customer')->with('Success', 'Data Customer Berhasil Dihapus');
    }

    public function exportCustomer(Request $request){
        $selectedItems = $request->input('items');

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Tidak ada Customer yang dipilih');
        }

        $data = Customer::whereIn('id', $selectedItems)->get();

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
        
        $pdf = SnappyPdf::loadView('export.exportCustomer', compact('data'))
                        ->setOptions($options)
                        ->setPaper('a4', 'landscape');
        


        $dateTime = date('d-m-Y  h:i:s');
        $fileName = "Laporan Customer - {$dateTime}.pdf";
        
        return $pdf->download($fileName);
    }
}
