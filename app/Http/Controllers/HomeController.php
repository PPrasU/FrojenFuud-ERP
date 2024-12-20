<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Produk;
use App\Models\Vendor;
use App\Models\Customer;
use App\Models\Quotation;
use App\Models\SalesOrder;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use App\Models\BillOfMaterial;
use App\Models\ManufacturingOrder;
use App\Models\RequestForQuotation;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $bahan = Bahan::all();
        $produk = Produk::all();
        $vendor = Vendor::all();
        $customer = Customer::all();
        $quotation = Quotation::all();
        $salesOrder = SalesOrder::all();
        $salesInvoice = SalesInvoice::all();
        $billOfMaterial = BillOfMaterial::all();
        $manufacturingOrder = ManufacturingOrder::all();
        $requestForQuotation = RequestForQuotation::all();
    
        // Contoh data yang akan ditampilkan pada dashboard
        $totalPendapatan = Quotation::sum('total_keseluruhan');  // Misal, mengambil total pendapatan dari sales invoice
        $totalCost = RequestForQuotation::sum('total');  // Misal, total biaya dari sales order
        $totalProfit = $totalPendapatan - $totalCost;  // Keuntungan = Pendapatan - Biaya
        
        // Misalkan, kita mengambil data profit bulan sebelumnya (jika ada) atau data historis lainnya
        $totalProfitPrevious = Quotation::whereMonth('created_at', '=', now()->subMonth()->month)
                                           ->sum('total_keseluruhan') - RequestForQuotation::whereMonth('created_at', '=', now()->subMonth()->month)
                                           ->sum('total');
        
        // Menghitung persentase perubahan
        $profitChangePercentage = 0;
        if ($totalProfitPrevious > 0) {
            $profitChangePercentage = (($totalProfit - $totalProfitPrevious) / $totalProfitPrevious) * 100;
        }
    
        // Tentukan arah caret berdasarkan perubahan persentase
        $caretDirection = $profitChangePercentage >= 0 ? 'fa-caret-up' : 'fa-caret-down';
        $percentageClass = $profitChangePercentage >= 0 ? 'text-success' : 'text-danger';
        $percentageText = number_format(abs($profitChangePercentage), 2); // Absolute value and 2 decimal places
        
        $goalCompletions = 1200;

        return view('dashboard.dashboard', compact(
            'bahan', 'produk', 'vendor', 'customer', 'quotation', 'salesOrder', 
            'salesInvoice', 'billOfMaterial', 'manufacturingOrder', 'requestForQuotation', 
            'totalPendapatan', 'totalCost', 'totalProfit', 'totalProfitPrevious',
            'profitChangePercentage', 'caretDirection', 'percentageClass', 'percentageText', 'goalCompletions'
        ));
    }
    
}
