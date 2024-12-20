<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Customer;
use App\Models\Quotation;
use App\Models\Pembayaran;
use App\Models\SalesOrder;
use App\Mail\QuotationMail;
use Illuminate\Http\Request;
use App\Models\QuotationItem;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Mail;
use Barryvdh\Snappy\Facades\SnappyPdf;


class QuotationController extends Controller
{
    public function Quotation(){
        $data = Quotation::all();
        return view('sales.quotation', compact('data'));
    }

    public function inputQuotation(){
        $customer = Customer::all();
        $pembayaran = Pembayaran::all();
        $produk = Produk::all();
    
        // Cari nomor quotation terakhir
        $lastQuotation = Quotation::orderBy('id', 'desc')->first();
        if ($lastQuotation) {
            // Ambil angka dari nomor terakhir dan tambahkan 1
            $lastNumber = (int) substr($lastQuotation->nomor_quotation, 1);
            $newNumber = 'S' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            // Jika belum ada quotation, mulai dari S00001
            $newNumber = 'S00001';
        }
    
        return view('sales.inputQuotation', compact('customer', 'pembayaran', 'produk', 'newNumber'));
    }    

    public function postQuotation(Request $request){
        $quotation = Quotation::create([
            'nomor_quotation' => $request->nomor_quotation,
            'customer_id' => $request->customer_id,
            'tanggal_quotation' => $request->tanggal_quotation,
            'berlaku_hingga' => $request->berlaku_hingga,
            'pembayaran_id' => $request->pembayaran_id,
            'total_sebelum_pajak' => $request->total_sebelum_pajak,
            'total_pajak' => $request->total_pajak,
            'total_keseluruhan' => $request->total_keseluruhan,
        ]);

        $produk_ids = $request->input('produk_id');
        $kuantitas = $request->input('kuantitas');
        $harga = $request->input('harga');
        $tax = $request->input('tax');
        $subtotal = $request->input('subtotal');

        for ($i = 0; $i < count($produk_ids); $i++) {
            $quotation->produks()->attach($produk_ids[$i], [
                'kuantitas' => $kuantitas[$i],
                'harga' => $harga[$i],
                'tax' => $tax[$i],
                'subtotal' => $subtotal[$i],
            ]);
        }

        return redirect()->route('Quotation')->with('Success', 'Quotation berhasil disimpan sebagai draft.');
    }

    public function editQuotation($id){
        $data = Quotation::find($id);
        $customer = Customer::all();
        $pembayaran = Pembayaran::all();
        $produk_p = Produk::all();
        $item = Quotation::with('produks')->findOrFail($id);
        return view('sales.editQuotation', compact('data', 'customer', 'pembayaran', 'produk_p', 'item'));
    }

    public function updateQuotation(Request $request, $id){
        $quotation = Quotation::findOrFail($id);

        $quotation->update([
            'nomor_quotation' => $request->nomor_quotation,
            'customer_id' => $request->customer_id,
            'tanggal_quotation' => $request->tanggal_quotation,
            'berlaku_hingga' => $request->berlaku_hingga,
            'pembayaran_id' => $request->pembayaran_id,
            'total_sebelum_pajak' => $request->total_sebelum_pajak,
            'total_pajak' => $request->total_pajak,
            'total_keseluruhan' => $request->total_keseluruhan,
        ]);

        $quotation->produks()->detach();

        $produk_ids = $request->input('produk_id');
        $kuantitas = $request->input('kuantitas');
        $harga = $request->input('harga');
        $tax = $request->input('tax');
        $subtotal = $request->input('subtotal');

        for ($i = 0; $i < count($produk_ids); $i++) {
            $quotation->produks()->attach($produk_ids[$i], [
                'kuantitas' => $kuantitas[$i],
                'harga' => $harga[$i],
                'tax' => $tax[$i],
                'subtotal' => $subtotal[$i],
            ]);
        }

        if ($request->has('send_by_email')) {
            $quotation->update(['status' => 'Sent']);
            return redirect()->route('Quotation')->with('Success', 'Status Quotation Menjadi Sent');
        } elseif ($request->has('confirm_quotation')) {
            $salesOrder = SalesOrder::create([
                'customer_id' => $quotation->customer_id,
                'quotation_id' => $quotation->id,
                'pembayaran_id' => $quotation->pembayaran_id,
            ]);
            $quotation->update(['status' => 'Confirmed to Sales Order']);
            return redirect()->route('Quotation')->with('Success', 'Status Quotation Sudah Dikonfirmasi Ke Sales Order');
        } elseif ($request->has('batalkan_quotation')) {
            $quotation->update(['status' => 'Cancelled']);
            return redirect()->route('Quotation')->with('Success', 'Status Quotation Dibatalkan');
        } elseif ($request->has('confirm_changes')) {
            $quotation->update(['status' => 'Draft']);
            return redirect()->route('editQuotation', ['id' => $quotation->id])
                ->with('Success', 'Berhasil Dilakukan Perubahan');
        }        
    }

    public function hapusQuotation($id){
        $quotation = Quotation::findOrFail($id);
        $quotation->delete();
        return redirect()->route('Quotation')->with('Success', 'Data Quotation Berhasil Dihapus');
    }

    public function exportQuotation(Request $request){
        $selectedItems = $request->input('items');

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Tidak ada produk yang dipilih');
        }

        $data = Quotation::whereIn('id', $selectedItems)->get();

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

        $pdf = SnappyPdf::loadView('export.exportQuotation', compact('data'))
            ->setOptions($options)
            ->setPaper('a4', 'portrait');

        $nomorQuotation = $data->first()->nomor_quotation;
        $tanggal = date('d-m-Y');
        $fileName = "Quotation-{$nomorQuotation} ({$tanggal}).pdf";

        return $pdf->download($fileName);
    }
    
    public function sendEmail(Request $request, $id){
        $validated = $request->validate([
            'emailTo' => 'required|email',
            'emailSubject' => 'required|string|max:255',
            'emailBody' => 'required|string',
        ]);

        // Kirim email menggunakan Mailable
        Mail::to($validated['emailTo'])->send(new QuotationMail($validated['emailSubject'], $validated['emailBody']));

        // Update status di database menjadi 'Sent'
        $quotation = Quotation::findOrFail($id);
        $quotation->update(['status' => 'Sent']);

        return redirect()->route('Quotation')->with('Success', 'Email berhasil dikirim dan status berhasil diperbarui.');
    }
}
