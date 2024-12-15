<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Customer;
use App\Models\Quotation;
use App\Models\Pembayaran;
use App\Models\SalesOrder;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\Snappy\Facades\SnappyPdf;

class SalesOrderController extends Controller
{
    public function SalesOrder(){
        $data = SalesOrder::all();
        return view('sales.salesOrder', compact('data'));
    }

    public function editSalesOrder($id){
        $data = SalesOrder::find($id);
        $produk = Produk::all();
        $customer = Customer::all();
        $pembayaran = Pembayaran::all();
        $quotation = Quotation::all();
        return view('sales.editSalesOrder', compact('data', 'customer', 'produk', 'pembayaran', 'quotation'));
    }

    public function updateSalesOrder(Request $request, $id){
        $currentYear = date('Y'); // Tahun saat ini
        $lastInvoice = SalesInvoice::whereYear('created_at', $currentYear)
            ->orderBy('id', 'desc')
            ->first();

        // Hitung nomor baru untuk invoice
        $newInvoiceNumber = $lastInvoice ? intval(substr($lastInvoice->nomor_invoice, -5)) + 1 : 1;
        $formattedInvoiceNumber = sprintf('INV/%s/%05d', $currentYear, $newInvoiceNumber);

        $salesOrder = SalesOrder::findOrFail($id);

        if ($request->has('validate_pengiriman')) {
            // Array untuk menyimpan status pengiriman per produk
            $produkStatus = [];

            foreach ($salesOrder->quotation->produks as $produk) {
                $requestedQuantity = $produk->pivot->kuantitas; // Kuantitas yang diminta
                if ($produk->kuantitas_produk >= $requestedQuantity) {
                    // Jika stok mencukupi
                    $produkStatus[$produk->id] = 'Tervalidasi';
                } else {
                    // Jika stok tidak mencukupi
                    $produkStatus[$produk->id] = 'Tidak Memenuhi';
                }
            }

            // Update status pengiriman berdasarkan hasil validasi produk
            $allValidated = true; // Flag untuk mengecek apakah semua produk tervalidasi
            foreach ($produkStatus as $status) {
                if ($status === 'Tidak Memenuhi') {
                    $allValidated = false;
                    break;
                }
            }

            // Tentukan status pengiriman pada Sales Order secara keseluruhan
            $salesOrderStatus = $allValidated ? 'Tervalidasi' : 'Tidak Memenuhi';
            $salesOrder->update(['pengiriman' => $salesOrderStatus]);

            // Buat pesan hasil validasi
            $successProducts = array_keys(array_filter($produkStatus, fn($status) => $status === 'Tervalidasi'));
            $failedProducts = array_keys(array_filter($produkStatus, fn($status) => $status === 'Tidak Memenuhi'));

            $successMessage = count($successProducts) > 0
                ? 'Produk tervalidasi: ' . implode(', ', array_map(fn($id) => $salesOrder->quotation->produks->find($id)->nama_produk, $successProducts))
                : '';
            $failedMessage = count($failedProducts) > 0
                ? 'Produk tidak memenuhi: ' . implode(', ', array_map(fn($id) => $salesOrder->quotation->produks->find($id)->nama_produk, $failedProducts))
                : '';

            return redirect()->route('editSalesOrder', ['id' => $salesOrder->id])
                ->with('success', "Validasi selesai. $successMessage $failedMessage");
        } elseif ($request->has('kirim_pengiriman')) {
            // Melakukan pengurangan kuantitas produk
            foreach ($salesOrder->quotation->produks as $produk) {
                $requestedQuantity = $produk->pivot->kuantitas;
                $produk->decrement('kuantitas_produk', $requestedQuantity);
            }

            // Update status pengiriman menjadi Selesai
            $salesOrder->update(['pengiriman' => 'Selesai']);
            return redirect()->route('editSalesOrder', ['id' => $salesOrder->id])
                ->with('Success', 'Pengiriman berhasil dilakukan dan stok produk telah diperbarui');
        } elseif ($request->has('buat_penagihan')) {
            // Buat invoice baru
            $salesOrder->update(['status' => 'Fully Invoiced', 'penagihan' => 'Sudah Dibuat']);
            $invoice = SalesInvoice::create([
                'customer_id' => $salesOrder->customer_id,
                'quotation_id' => $salesOrder->quotation->id,
                'sales_order_id' => $salesOrder->id,
                'pembayaran_id' => $salesOrder->pembayaran->id,
                'nomor_invoice' => $formattedInvoiceNumber,
                'tanggal_invoice' => $salesOrder->quotation->tanggal_quotation,
                'tanggal_pembayaran_invoice' => null,
            ]);

            return redirect()->route('editSalesOrder', ['id' => $salesOrder->id])
                ->with('Success', 'Status Sales Order berhasil diperbarui menjadi Fully Invoiced dan Invoice baru berhasil dibuat');
        } else if ($request->has('batalkan_sales_order')){
            $salesOrder->update(['status' => 'Cancelled']);
            return redirect()->route('editSalesOrder', ['id' => $salesOrder->id])
                ->with('Success', 'Sales Order Dibatalkan');
        }

        return redirect()->back()->with('error', 'Tidak ada aksi valid yang dipilih.');
    }

    public function hapusSalesOrder($id){
        $salesOrder = SalesOrder::findOrFail($id);
        $quotationID = $salesOrder->quotation_id;

        $salesOrder->delete();

        $quotation = Quotation::find($quotationID);
        if ($quotation) {
            $quotation->update([
                'status' => 'Draft',
            ]);
        }
        return redirect()->route('SalesOrder')->with('Success', 'Data Sales Order Berhasil Dihapus');
    }

    public function exportSalesOrder(Request $request){
        $selectedItems = $request->input('items');

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Tidak ada Sales Order yang dipilih');
        }

        $data = SalesOrder::whereIn('id', $selectedItems)->get();

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

        // Access nomor_quotation from the related quotation of the first sales order
        $dateTime = date('d-m-Y');
        $nomorSalesOrder = $data->first()->quotation->nomor_quotation ?? 'SalesOrder';
        $fileName = "Sales Order-{$nomorSalesOrder} ($dateTime).pdf";

        $pdf = SnappyPdf::loadView('export.exportSalesOrder', compact('data'))
            ->setOptions($options)
            ->setPaper('a4', 'landscape');

        return $pdf->download($fileName);
    }

    public function a(){
        $data = SalesOrder::all();
        return view('export.exportSalesOrder', compact('data'));
    }
}
