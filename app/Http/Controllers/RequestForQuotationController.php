<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestForQuotation;
use App\Models\PurchaseOrder;
use App\Models\Produk;
use App\Models\Bahan;
use App\Models\Vendor;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;
use App\Mail\RFQMail;
use Barryvdh\Snappy\Facades\SnappyPdf;

class RequestForQuotationController extends Controller
{
    public function RequestForQuotation(){
        $data = RequestForQuotation::with('vendor')->get();
        // dd($data);
        return view('RFQ.RequestForQuotation', compact('data'));
    }

    public function inputRequestForQuotation(){
        $data = RequestForQuotation::all();
        $produk = Produk::all();
        $bahan = Bahan::all();
        $vendor = Vendor::all(); // Ambil semua vendor
        return view('RFQ.inputRequestForQuotation', compact('produk', 'data', 'bahan', 'vendor'));
    }

    public function postRequestForQuotation(Request $request){
        $request->validate([
            'reference' => 'required|string|max:255',
            'vendor_id' => 'required|exists:vendors,id',
            'tanggal' => 'required|date',
            'total' => 'nullable|numeric|min:0',
            'bahan_id.*' => 'required|exists:bahans,id',
            'kuantitas.*' => 'required|integer|min:1|max:99999',
            'satuan.*' => 'required|string|max:50',
        ]);
    
        $vendor = Vendor::findOrFail($request->vendor_id);
    
        $requestForQuotation = RequestForQuotation::create([
            'reference' => $request->reference,
            'vendor_reference' => $vendor->kategori,
            'vendor_id' => $request->vendor_id,
            'tanggal' => $request->tanggal,
            'company' => $request->company,
            'total' => $request->total ?: 0,
            'status' => 'RFQ', // Pastikan status disimpan
        ]);
    
        foreach ($request->bahan_id as $index => $bahanId) {
            $requestForQuotation->bahans()->attach($bahanId, [
                'kuantitas' => $request->kuantitas[$index],
                'satuan' => $request->satuan[$index],
            ]);
        }
    
        // Debug untuk memverifikasi status
        logger()->info('Data RFQ yang ditambahkan:', $requestForQuotation->toArray());
    
        return redirect()->route('RequestForQuotation')->with('Success', 'Data RFQ berhasil ditambahkan.');
    }
    
    public function changeStatusToPO($id){
        $rfq = RequestForQuotation::find($id);
    
        if (!$rfq) {
            return redirect()->back()->with('error', 'RFQ tidak ditemukan.');
        }
    
        if ($rfq->status === 'PO') {
            return redirect()->back()->with('info', 'RFQ sudah dalam status PO.');
        }
    
        $rfq->status = 'PO';
        $rfq->save();
    
        return redirect()->route('RequestForQuotation')->with('Success', 'Status RFQ berhasil diubah menjadi PO.');
    }    

    public function editRequestForQuotation($id){
        $data = RequestForQuotation::with('vendor', 'bahans')->findOrFail($id);
        $vendor = Vendor::all();
        $produk = Produk::all();
        $bahan = Bahan::all();
        $bahanOptions = Bahan::all();

        return view('RFQ.editRequestForQuotation', compact('data', 'vendor', 'produk', 'bahan', 'bahanOptions'));
    }

    public function updateRequestForQuotation(Request $request, $id) {
        $data = RequestForQuotation::findOrFail($id);
    
        // Debug input untuk memastikan data dikirimkan
        logger()->info('Request Data:', $request->all());
    
        // Periksa apakah "ubah_ke_po" bernilai "1"
        if ($request->input('ubah_ke_po') === '1') {
            $data->update(['status' => 'PO']);
            logger()->info('Status RFQ berhasil diubah menjadi PO:', $data->toArray());
            return redirect()->route('RequestForQuotation')->with('Success', 'Status RFQ berhasil diubah menjadi PO.');
        }
    
        // Update data utama RFQ
        $data->update([
            'reference' => $request->reference,
            'vendor_id' => $request->vendor_id,
            'tanggal' => $request->tanggal,
            'company' => $request->company,
            'total' => $request->total,
            
        ]);
    
        // Hapus data lama di tabel pivot
        $data->bahans()->detach();
    
        // Ambil data bahan untuk tabel pivot
        $bahanIds = $request->input('bahan_id');
        $kuantitas = $request->input('kuantitas');
        $satuan = $request->input('satuan');
    
        // Tambahkan data baru ke tabel pivot
        for ($i = 0; $i < count($bahanIds); $i++) {
            $data->bahans()->attach($bahanIds[$i], [
                'kuantitas' => $kuantitas[$i],
                'satuan' => $satuan[$i],
            ]);
        }
    
        // Debug untuk memverifikasi data bahan
        logger()->info('Bahan berhasil diperbarui:', $data->bahans->toArray());
        if($request->has('confirm_changes')){
            return redirect()->route('editRequestForQuotation', ['id' => $data->id])
                ->with('Success', 'Berhasil Dilakukan Perubahan');
        }
    
        return redirect()->route('RequestForQuotation')->with('Success', 'Data RFQ berhasil diperbarui.');
    }    

    public function hapusRequestForQuotation($id){
        $rfq = RequestForQuotation::findOrFail($id);
    
        // Hapus hubungan dengan item jika ada
        if ($rfq->items()->exists()) {
            $rfq->items()->delete();
        }
    
        $rfq->delete();
    
        return redirect()->route('RequestForQuotation')->with('Success', 'Data berhasil dihapus.');
    }
    
    public function index(){
        $data = RequestForQuotation::with(['vendor', 'items'])->get();
        foreach ($data as $rfq) {
            $rfq->total = $rfq->items->sum(function ($item) {
                return $item->harga_bahan * $item->kuantitas;
            });
        }
        return view('RFQ\RequestForQuotation', compact('data'));
    }

    public function exportRequestForQuotation(Request $request){
        $selectedItems = $request->input('items', []);
        $vendor_id = $request->input('vendor_id'); // Mendapatkan vendor_id dari request

        // Mengambil vendor yang sesuai dengan vendor_id
        $vendor = Vendor::find($vendor_id);

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Tidak ada Request For Quotation yang dipilih');
        }

        // Mengambil data request_for_quotations dan bahan terkait
        $data = RequestForQuotation::with(['vendor', 'quotation_bahans.bahan'])
            ->whereIn('id', $selectedItems)
            ->get();

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

        // Kirim data ke view
        $pdf = SnappyPdf::loadView('export.exportRFQ', compact('data', 'vendor'))
            ->setOptions($options)
            ->setPaper('a4', 'landscape');

        $dateTime = date('d-m-Y  h:i:s');
        $fileName = "Laporan Request For Quotation - {$dateTime}.pdf";

        return $pdf->download($fileName);
    }

    public function updateStatus(Request $request, $id){
        $rfq = RequestForQuotation::findOrFail($id);
    
        // Periksa apakah status valid untuk diubah
        if ($rfq->status === 'RFQ') {
            $rfq->status = 'RFQ Sent';
            $rfq->save();
            return response()->json(['message' => 'Status updated to RFQ Sent']);
        }
    
        return response()->json(['error' => 'Status cannot be updated'], 400);
    }

    public function hapus($id){
        $rfq = RequestForQuotation::findOrFail($id);
        $rfq->delete();

        return redirect()->route('RequestForQuotation')->with('Success', 'Data berhasil dihapus.');
    }
    
    public function sendEmail(Request $request, $id){
        // Cari RFQ berdasarkan ID
        $rfq = RequestForQuotation::findOrFail($id);
    
        // Validasi input
        $request->validate([
            'emailSubject' => 'required|string|max:255',
            'emailBody' => 'required|string',
            'emailAttachment' => 'nullable|file|mimes:pdf,doc,docx',
            'kuantitas.*' => 'required|integer|min:1',
            'satuan.*' => 'required|string|max:50',
        ]);
    
        // Update kuantitas bahan jika ada
        if ($request->bahan_id) {
            $rfq->bahans()->detach();
            foreach ($request->bahan_id as $index => $bahanId) {
                $rfq->bahans()->attach($bahanId, [
                    'kuantitas' => $request->kuantitas[$index],
                    'satuan' => $request->satuan[$index],
                ]);
            }
        }
    
        // Persiapkan email
        $details = [
            'subject' => $request->emailSubject,
            'body' => $request->emailBody,
            'attachment' => $request->file('emailAttachment'),
        ];
    
        // Kirim email ke vendor
        try {
            Mail::to($rfq->vendor->email)->send(new RFQMail($details));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    
        // Perbarui status RFQ
        $rfq->status = 'RFQ Sent';
        $rfq->save();
    
        return redirect()->route('RequestForQuotation')->with('Success', 'Email berhasil dikirim dan status RFQ diperbarui.');
    }
    
    
//=====================================================================PO======================================================================

    public function PurchaseOrder(){
        $data1 = RequestForQuotation::with(['vendor'])->where('status', 'PO')->get();
        return view('RFQ.PurchaseOrder', compact('data1'));
    }

    public function editPurchaseOrder($id){
        $data1 = RequestForQuotation::with(['vendor', 'bahans'])->findOrFail($id);
        $vendor = Vendor::all();
        $produk = Produk::all();
        $bahan = Bahan::all();
        $bahanOptions = Bahan::all();

        return view('RFQ.editPurchaseOrder', compact('data1', 'vendor', 'produk', 'bahan', 'bahanOptions'));
    }

    public function updatePurchaseOrder(Request $request, $id){
        $data1 = RequestForQuotation::findOrFail($id);

        // Periksa apakah "ubah_ke_po" bernilai "1"
        if ($request->input('ubah_ke_po') === '1') {
            $data1->status = 'PO';
            $data1->save();

            return redirect()->route('PurchaseOrder')->with('Success', 'Status RFQ berhasil diubah menjadi PO.');
        }

        // Validasi input
        $request->validate([
            'reference' => 'required|string|max:255',
            'vendor_id' => 'required|exists:vendors,id',
            'tanggal' => 'required|date',
            'company' => 'nullable|string|max:255',
            'bahan_id.*' => 'nullable|exists:bahans,id',
            'kuantitas.*' => 'nullable|integer|min:1|max:99999',
            'satuan.*' => 'nullable|string|max:50',
        ]);

        $data1->update([
            'reference' => $request->reference,
            'vendor_id' => $request->vendor_id,
            'tanggal' => $request->tanggal,
            'company' => $request->company,
        ]);

        // Perbarui bahan jika ada
        if ($request->bahan_id) {
            $data1->bahans()->detach();
            foreach ($request->bahan_id as $index => $bahanId) {
                $data1->bahans()->attach($bahanId, [
                    'kuantitas' => $request->kuantitas[$index],
                    'satuan' => $request->satuan[$index],
                ]);
            }
        }

        return redirect()->route('PurchaseOrder')->with('Success', 'Data RFQ berhasil diperbarui.');
    }

    public function hapusPurchaseOrder($id){
        $rfq = RequestForQuotation::findOrFail($id);

        // Hapus hubungan dengan bahan jika ada
        if ($rfq->bahans()->exists()) {
            $rfq->bahans()->detach();
        }

        $rfq->delete();

        return redirect()->route('PurchaseOrder')->with('Success', 'Data berhasil dihapus.');
    }

    public function exportPurchaseOrder(Request $request){
        $selectedItems = $request->input('items');

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Tidak ada Purchase Order yang dipilih');
        }

        $data1 = RequestForQuotation::whereIn('id', $selectedItems)->where('status', 'PO')->get();

        if ($data1->isEmpty()) {
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

        $pdf = SnappyPdf::loadView('export.exportPurchaseOrder', compact('data1'))
                        ->setOptions($options)
                        ->setPaper('a4', 'landscape');
        $dateTime = date('d-m-Y  h:i:s');
        $fileName = "Laporan PurchaseOrder - {$dateTime}.pdf";

        return $pdf->download($fileName);
    }

    public function detail($id){
        $PO = RequestForQuotation::with('bahans')->find($id);
    
        if (!$PO || $PO->status !== 'PO') {
            return redirect()->route('PurchaseOrder')->with('error', 'Detail Purchase Order tidak valid.');
        }
    
        return view('RFQ.detailPurchaseOrder', compact('PO'));
    }

    // public function createBill_BERHASIL($id){
    //     $PO = RequestForQuotation::find($id);

    //     if (!$PO || $PO->status_po !== 'Waiting to bill') {
    //         return redirect()->back()->with('error', 'Tidak dapat membuat bill.');
    //     }

    //     $PO->update(['status_po' => 'Fully billed']);

    //     return redirect()->route('PurchaseOrder')->with('Success', 'Bill berhasil dibuat.');
    // }

    public function receiveProduct($id){
        $PO = RequestForQuotation::with('bahans')->find($id);
    
        // Periksa status PO sebelum menerima produk
        if (!$PO || $PO->status_po !== 'Nothing to bill') {
            return redirect()->back()->with('error', 'Produk tidak dapat diterima.');
        }
    
        // Tambah kuantitas_bahan di tabel bahan
        foreach ($PO->bahans as $bahan) {
            // Tambahkan kuantitas dari pivot ke kuantitas_bahan di tabel bahan
            $bahan->increment('kuantitas_bahan', $bahan->pivot->kuantitas);
        }
    
        // Update status received dan status_po di tabel request_for_quotations
        $PO->update([
            'received' => 'Sudah', // Update kolom received
            'status_po' => 'Waiting to bill', // Update status_po
        ]);
    
        return redirect()->route('PurchaseOrder')->with('Success', 'Produk berhasil diterima.');
    }

    public function updateStatusPo(Request $request, $id){
        $rfq = RequestForQuotation::findOrFail($id);

        if ($rfq->status === 'RFQ') {
            $rfq->status = 'RFQ Sent';
            $rfq->save();
            return response()->json(['message' => 'Status updated to RFQ Sent']);
        }

        return response()->json(['error' => 'Status cannot be updated'], 400);
    }

    public function sendEmailPo(Request $request, $id){
        $rfq = RequestForQuotation::findOrFail($id);

        $details = [
            'subject' => $request->emailSubject,
            'body' => $request->emailBody,
            'attachment' => $request->file('emailAttachment'),
        ];

        try {
            Mail::to($rfq->vendor->email)->send(new RFQMail($details));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }

        $rfq->status = 'RFQ Sent';
        $rfq->save();

        return redirect()->route('PurchaseOrder')->with('Success', 'Email berhasil dikirim dan status RFQ diperbarui!');
    }
// ===================================================================BILL=================================================================
    public function createBill(Request $request, $id){
        // Ambil data PO berdasarkan ID
        $po = RequestForQuotation::findOrFail($id);

        // Validasi status PO
        if ($po->status_po != 'Waiting to bill') {
            return redirect()->back()->with('error', 'Hanya PO dengan status "Waiting to bill" yang dapat membuat Bill.');
        }

        // Pastikan status bill adalah Draft
        if ($po->status_bill != 'Draft') {
            return redirect()->back()->with('error', 'Bill sudah dibuat sebelumnya.');
        }

        $po->update([
            'status_bill' => 'Draft',
        ]);

        // Update status PO menjadi Fully Billed jika sesuai
        $po->update(['status_po' => 'Fully Billed']);

        return redirect()->route('vendorBill')->with('Success', 'Bill berhasil dibuat.');
    }

    public function draftBills(){
        $draftBills = RequestForQuotation::with('vendor')->where('status_bill', 'Draft')->get();

        return view('invoice.draftBillVendor', compact('draftBills'));
    }

    public function showBillDetail($id){
        $bill = RequestForQuotation::findOrFail($id);

        return view('invoice.billDetail', compact('bill'));
    }

    public function confirmBill($id){
        $bill = RequestForQuotation::findOrFail($id);

        // Update status menjadi 'Not Paid'
        $bill->update(['status_bill' => 'Not Paid']);

        // Redirect ke halaman Vendor Bill
        return redirect('/VendorBill')->with('Success', 'Bill dikonfirmasi.');
    }

    public function payBill(Request $request, $id){
        // Temukan bill berdasarkan ID
        $bill = RequestForQuotation::findOrFail($id);
    
        // Update status bill menjadi 'Paid'
        $bill->update(['status_bill' => 'Paid']);
    
        // Simpan informasi pembayaran
        Payment::create([
            'rfq_id' => $bill->id,
            'payment_method' => $request->payment_method,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
        ]);
    
        // Update status PO menjadi 'Fully Billed' jika bill sudah dibayar
        $bill->update(['status_po' => 'Fully Billed']);
    
        // Redirect kembali ke halaman Vendor Bill
        return redirect()->route('vendorBill')->with('Success', 'Pembayaran berhasil dibuat dan PO diperbarui.');
    }

    public function vendorBillPage()
    {
        // Hanya ambil data dengan status bill tertentu
        $vendorBills = RequestForQuotation::with('vendor')
            ->whereIn('status_bill', ['Draft', 'Not Paid', 'Paid'])
            ->get();
    
        return view('invoice.vendorBill', compact('vendorBills'));
    }

    public function exportVendorBill(Request $request){
        $selectedItems = $request->input('items');

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Tidak ada Vendor Bill yang dipilih');
        }

        $data = RequestForQuotation::whereIn('id', $selectedItems)->get();

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

        $dateTime = date('d-m-Y  h:i:s');
        $fileName = "Vendor Bill ($dateTime).pdf";

        $pdf = SnappyPdf::loadView('export.exportVendorBill', compact('data'))
            ->setOptions($options)
            ->setPaper('a4', 'landscape');

        return $pdf->download($fileName);
    }
}