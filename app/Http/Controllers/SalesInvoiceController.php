<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Customer;
use App\Models\Pembayaran;
use App\Models\SalesOrder;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\Snappy\Facades\SnappyPdf;

class SalesInvoiceController extends Controller
{
    public function SalesInvoice(){
        $data = SalesInvoice::all();
        return view('invoicing.invoice', compact('data'));
    }

    public function editSalesInvoice($id){
        $data = SalesInvoice::find($id);
        $produk = Produk::all();
        $customer = Customer::all();
        $pembayaran = Pembayaran::all();
        $salesOrder = SalesOrder::all();
        return view('invoicing.editInvoice', compact('data', 'produk', 'customer', 'salesOrder', 'pembayaran'));
    }

    public function updateSalesInvoice(Request $request, $id){
        $salesInvoice = SalesInvoice::findOrFail($id);
         
        if ($request->has('konfirmasi_invoice')) {
            $salesInvoice->update(['status' => 'Not Paid']);
            return redirect()->route('SalesInvoice')->with('Success', 'Status Sales Invoice Menjadi Not Paid');

        } else if ($request->has('bayar')) {
            $request->validate([
                'tanggal_pembayaran_invoice' => 'required|date',
            ]);
            $salesInvoice->update([
                'status' => 'Paid',
                'tanggal_pembayaran_invoice' => $request->tanggal_pembayaran_invoice,
            ]);

            return redirect()->route('SalesInvoice')->with('Success', 'Status Sales Invoice Menjadi Paid dan Tanggal Pembayaran Ditambahkan.');
        }

        return redirect()->back()->with('error', 'Aksi tidak valid.');
    }

    public function hapusSalesInvoice($id){
        $salesInvoice = SalesInvoice::findOrFail($id);
        $salesOrderId = $salesInvoice->sales_order_id;

        $salesInvoice->delete();

        $salesOrder = SalesOrder::find($salesOrderId);
        if ($salesOrder) {
            $salesOrder->update([
                'status' => 'To Invoiced', 
                'penagihan' => 'Belum',  
            ]);
        }

        return redirect()->route('SalesInvoice')->with('Success', 'Data Sales Invoice Berhasil Dihapus');
    }

    // public function exportSalesInvoice(Request $request){
    //     $selectedItems = $request->input('items');

    //     if (empty($selectedItems)) {
    //         return redirect()->back()->with('error', 'Tidak ada Sales Order yang dipilih');
    //     }

    //     $data = SalesInvoice::whereIn('id', $selectedItems)->get();

    //     if ($data->isEmpty()) {
    //         return redirect()->back()->with('error', 'Data tidak ditemukan.');
    //     }

    //     $options = [
    //         'margin-top' => 10,
    //         'margin-right' => 10,
    //         'margin-bottom' => 10,
    //         'margin-left' => 10,
    //         'javascript-delay' => 500,
    //         'no-stop-slow-scripts' => true,
    //         'disable-smart-shrinking' => true,
    //     ];

    //     // Ambil nomor_invoice dari item pertama dalam $data
    //     $nomorInvoice = $data->first()->nomor_invoice ?? 'SalesInvoice';
    //     $fileName = "Sales Invoice ({$nomorInvoice}).pdf";

    //     // Generate PDF dengan data yang tersedia
    //     $pdf = SnappyPdf::loadView('export.exportSalesInvoice', compact('data'))
    //         ->setOptions($options)
    //         ->setPaper('a4', 'landscape');

    //     return $pdf->download($fileName);
    // }

    public function exportSalesInvoice(Request $request){
        $selectedItems = $request->input('items');

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Tidak ada Sales Order yang dipilih');
        }

        $data = SalesInvoice::whereIn('id', $selectedItems)->get();

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

        $dateTime = date('d-m-Y');
        $nomorSalesInvoice = $data->first()->nomor_invoice ?? 'SalesInvoice';
        $fileName = "Sales Order-{$nomorSalesInvoice} ($dateTime).pdf";

        $pdf = SnappyPdf::loadView('export.exportSalesInvoice', compact('data'))
            ->setOptions($options)
            ->setPaper('a4', 'landscape');

        return $pdf->download($fileName);
    }

}
