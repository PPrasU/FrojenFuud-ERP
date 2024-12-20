<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\RequestForQuotation;
use App\Models\Produk;
use App\Models\Bahan;
use App\Models\Vendor;
use Illuminate\Support\Facades\Mail;
use App\Mail\RFQMail;
use Barryvdh\Snappy\Facades\SnappyPdf;

class PurchaseOrderController extends Controller
{
    public function index(){
        $purchaseOrders = PurchaseOrder::with(['rfq', 'vendor'])
        ->whereHas('rfq', function ($query) {
            $query->where('status', 'PO');
        })
        ->get();
    
        if ($purchaseOrders->isEmpty()) {
            dump('Data kosong');
        } else {
            dump($purchaseOrders);
        }

        return view('RFQ.purchaseOrder', compact('purchaseOrders'));
    }

    public function detail($id)
    {
        $purchaseOrder = PurchaseOrder::with(['rfq', 'vendor'])->findOrFail($id);
        return view('purchase_order.detail', compact('purchaseOrder'));
    }

    public function receiveProduct($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $rfq = $purchaseOrder->rfq;

        if ($purchaseOrder->received === 'Belum') {
            // Tambahkan produk ke database
            foreach ($rfq->bahans as $bahan) {
                $produk = Produk::find($bahan->id);
                if ($produk) {
                    $produk->kuantitas_produk += $bahan->pivot->kuantitas;
                    $produk->save();
                }
            }

            $purchaseOrder->received = 'Sudah';
            $purchaseOrder->status = 'Waiting to bill';
            $purchaseOrder->save();
        }

        return redirect()->route('RFQ.purchaseOrder')->with('success', 'Produk berhasil diterima.');
    }

    public function createBill($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);

        if ($purchaseOrder->status === 'Waiting to bill') {
            $purchaseOrder->status = 'Fully billed';
            $purchaseOrder->billed = 'Sudah';
            $purchaseOrder->save();
        }

        return redirect()->route('RFQ.purchaseOrder')->with('success', 'Bill berhasil dibuat.');
    }

    public function confirmOrder($id)
    {
        // Cari Purchase Order berdasarkan ID
        $purchaseOrder = PurchaseOrder::find($id);

        // Jika data tidak ditemukan
        if (!$purchaseOrder) {
            return redirect()->back()->withErrors(['error' => 'Purchase Order tidak ditemukan.']);
        }

        // Periksa apakah statusnya 'draft' (atau status lainnya yang relevan)
        if ($purchaseOrder->status !== 'draft') {
            return redirect()->back()->withErrors(['error' => 'Hanya Purchase Order dengan status draft yang dapat dikonfirmasi.']);
        }

        // Update status menjadi 'confirmed'
        $purchaseOrder->update(['status' => 'confirmed']);

        return redirect()->route('PurchaseOrder')->with('success', 'Purchase Order berhasil dikonfirmasi.');
    }

    public function PurchaseOrder(){
        $data = PurchaseOrder::with('vendor')->get();
        dd($data);
        return view('RFQ.PurchaseOrder', compact('data'));
    }

    public function inputPurchaseOrder(){
        $data = PurchaseOrder::all();
        $produk = Produk::all();
        $bahan = Bahan::all();
        $vendor = Vendor::all(); // Ambil semua vendor
        return view('RFQ.inputPurchaseOrder', compact('produk', 'data', 'bahan', 'vendor'));
    }

    public function postPurchaseOrder(Request $request){
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
    
        $requestForQuotation = PurchaseOrder::create([
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
    
        return redirect()->route('PurchaseOrder')->with('success', 'Data RFQ berhasil ditambahkan.');
    }

    public function changeStatusToPO($id)
    {
        $rfq = PurchaseOrder::find($id);
    
        if (!$rfq) {
            return redirect()->back()->with('error', 'RFQ tidak ditemukan.');
        }
    
        if ($rfq->status === 'PO') {
            return redirect()->back()->with('info', 'RFQ sudah dalam status PO.');
        }
    
        $rfq->status = 'PO';
        $rfq->save();
    
        return redirect()->route('PurchaseOrder')->with('success', 'Status RFQ berhasil diubah menjadi PO.');
    }    

    public function editPurchaseOrder($id){
        $data = PurchaseOrder::with('vendor', 'bahans')->findOrFail($id);
        $vendor = Vendor::all();
        $produk = Produk::all();
        $bahan = Bahan::all();
        $bahanOptions = Bahan::all();

        return view('RFQ.editPurchaseOrder', compact('data', 'vendor', 'produk', 'bahan', 'bahanOptions'));
    }

    public function updatePurchaseOrder(Request $request, $id)
    {
        $data = PurchaseOrder::findOrFail($id);

        // Debug input untuk memastikan data dikirimkan
        logger()->info('Request Data:', $request->all());

        // Periksa apakah "ubah_ke_po" bernilai "1"
        if ($request->input('ubah_ke_po') === '1') {
            $data->status = 'PO';
            $data->save();

            // Debug untuk memastikan status diubah
            logger()->info('Status RFQ berhasil diubah menjadi PO:', $data->toArray());

            return redirect()->route('PurchaseOrder')->with('success', 'Status RFQ berhasil diubah menjadi PO.');
        }

        // Lanjutkan ke logika pembaruan lainnya
        $request->validate([
            'reference' => 'required|string|max:255',
            'vendor_id' => 'required|exists:vendors,id',
            'tanggal' => 'required|date',
            'company' => 'nullable|string|max:255',
            'bahan_id.*' => 'nullable|exists:bahans,id',
            'kuantitas.*' => 'nullable|integer|min:1|max:99999',
            'satuan.*' => 'nullable|string|max:50',
        ]);

        $data->update([
            'reference' => $request->reference,
            'vendor_id' => $request->vendor_id,
            'tanggal' => $request->tanggal,
            'company' => $request->company,
        ]);

        // Perbarui bahan jika ada
        if ($request->bahan_id) {
            $data->bahans()->detach();
            foreach ($request->bahan_id as $index => $bahanId) {
                $data->bahans()->attach($bahanId, [
                    'kuantitas' => $request->kuantitas[$index],
                    'satuan' => $request->satuan[$index],
                ]);
            }
        }

        return redirect()->route('PurchaseOrder')->with('success', 'Data RFQ berhasil diperbarui.');
    }

    public function hapusPurchaseOrder($id)
    {
        $rfq = PurchaseOrder::findOrFail($id);
    
        // Hapus hubungan dengan item jika ada
        if ($rfq->items()->exists()) {
            $rfq->items()->delete();
        }
    
        $rfq->delete();
    
        return redirect()->route('PurchaseOrder')->with('success', 'Data berhasil dihapus.');
    }
    
    public function index1()
    {
        $data = PurchaseOrder::with(['vendor', 'items'])->get();
        foreach ($data as $rfq) {
            $rfq->total = $rfq->items->sum(function ($item) {
                return $item->harga_bahan * $item->kuantitas;
            });
        }
        return view('RFQ\PurchaseOrder', compact('data'));
    }

    public function exportPurchaseOrder(Request $request){
        $selectedItems = $request->input('items');

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Tidak ada PurchaseOrder yang dipilih');
        }

        $data = PurchaseOrder::whereIn('id', $selectedItems)->get();

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
        
        $pdf = SnappyPdf::loadView('export.exportPurchaseOrder', compact('data'))
                        ->setOptions($options)
                        ->setPaper('a4', 'landscape');
        $dateTime = date('d-m-Y  h:i:s');
        $fileName = "Laporan PurchaseOrder - {$dateTime}.pdf";
        
        return $pdf->download($fileName);
    }

    public function updateStatus(Request $request, $id)
    {
        $rfq = PurchaseOrder::findOrFail($id);
    
        // Periksa apakah status valid untuk diubah
        if ($rfq->status === 'RFQ') {
            $rfq->status = 'RFQ Sent';
            $rfq->save();
            return response()->json(['message' => 'Status updated to RFQ Sent']);
        }
    
        return response()->json(['error' => 'Status cannot be updated'], 400);
    }

    public function hapus($id)
    {
        $rfq = PurchaseOrder::findOrFail($id);
        $rfq->delete();

        return redirect()->route('PurchaseOrder')->with('success', 'Data berhasil dihapus.');
    }
    
    public function sendEmail(Request $request, $id)
    {
        // Cari data RFQ berdasarkan ID
        $rfq = PurchaseOrder::findOrFail($id);
    
        // Kirim email (Anda dapat menyesuaikan sesuai dengan logika pengiriman email)
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
    
        // Perbarui status RFQ
        $rfq->status = 'RFQ Sent';
        $rfq->save();
    
        return redirect()->route('PurchaseOrder')->with('success', 'Email berhasil dikirim dan status RFQ diperbarui!');
    }
}