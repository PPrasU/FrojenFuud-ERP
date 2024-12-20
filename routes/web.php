<?php

use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\SalesInvoiceController;
use App\Http\Controllers\BillOfMaterialController;
use App\Http\Controllers\ManufacturingOrderController;
use App\Http\Controllers\RequestForQuotationController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

//======= Login ====================================================================================

Auth::routes();

//dashboard
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//====== Produk ========================================================================================
//urutan input, post, edit, update, hapus, pdf
Route::get('/produk', [ProdukController::class, 'Produk'])->name('Produk');
Route::get('/produk/input', [ProdukController::class, 'inputProduk'])->name('inputProduk');
Route::post('/produk/post', [ProdukController::class, 'postProduk'])->name('postProduk');
Route::get('/produk/edit/{id}', [ProdukController::class, 'editProduk'])->name('editProduk');
Route::post('/produk/update/{id}', [ProdukController::class, 'updateProduk'])->name('updateProduk');
Route::get('/produk/hapus/{id}', [ProdukController::class, 'hapusProduk'])->name('hapusProduk');
Route::post('/produk/export', [ProdukController::class, 'exportProduk'])->name('exportProduk');

// Route::get('/produk', function () {
//     return view('product.produk');
// });

//====== Bahan Baku ========================================================================================
Route::get('/bahan-baku', [BahanController::class, 'Bahan'])->name('Bahan');
Route::get('/bahan-baku/input', [BahanController::class, 'inputBahan'])->name('inputBahan');
Route::post('/bahan-baku/post', [BahanController::class, 'postBahan'])->name('postBahan');
Route::get('/bahan-baku/edit/{id}', [BahanController::class, 'editBahan'])->name('editBahan');
Route::post('/bahan-baku/update/{id}', [BahanController::class, 'updateBahan'])->name('updateBahan');
Route::get('/bahan-baku/hapus/{id}', [BahanController::class, 'hapusBahan'])->name('hapusBahan');
Route::post('/bahan-baku/export', [BahanController::class, 'exportBahan'])->name('exportBahan');

// Route::get('/bahan-baku', function () {
//     return view('product.bahan');
// });

//====== BillOfMaterial ========================================================================================
Route::get('/BillOfMaterial', [BillOfMaterialController::class, 'BillOfMaterial'])->name('BillOfMaterial');
Route::get('/BillOfMaterial/input', [BillOfMaterialController::class, 'inputBillOfMaterial'])->name('inputBillOfMaterial');
Route::post('/BillOfMaterial/post', [BillOfMaterialController::class, 'postBillOfMaterial'])->name('postBillOfMaterial');
Route::get('/BillOfMaterial/edit/{id}', [BillOfMaterialController::class, 'editBillOfMaterial'])->name('editBillOfMaterial');
Route::post('/BillOfMaterial/update/{id}', [BillOfMaterialController::class, 'updateBillOfMaterial'])->name('updateBillOfMaterial');
Route::get('/BillOfMaterial/hapus/{id}', [BillOfMaterialController::class, 'hapusBillOfMaterial'])->name('hapusBillOfMaterial');
Route::post('/BillOfMaterial/export', [BillOfMaterialController::class, 'exportBillOfMaterial'])->name('exportBillOfMaterial');

//====== Vendor ========================================================================================
Route::get('/Vendors', [VendorController::class, 'Vendor'])->name('Vendor');
Route::get('/Vendors/input', [VendorController::class, 'inputVendor'])->name('inputVendor');
Route::post('/Vendors/post', [VendorController::class, 'postVendor'])->name('postVendor');
Route::get('/Vendors/edit/{id}', [VendorController::class, 'editVendor'])->name('editVendor');
Route::post('/Vendors/update/{id}', [VendorController::class, 'updateVendor'])->name('updateVendor');
Route::get('/Vendors/hapus/{id}', [VendorController::class, 'hapusVendor'])->name('hapusVendor');
Route::post('/Vendors/export', [VendorController::class, 'exportVendor'])->name('exportVendor');


//====== Customer ========================================================================================
Route::get('/Customer', [CustomerController::class, 'Customer'])->name('Customer');
Route::get('/Customer/input', [CustomerController::class, 'inputCustomer'])->name('inputCustomer');
Route::post('/Customer/post', [CustomerController::class, 'postCustomer'])->name('postCustomer');
Route::get('/Customer/edit/{id}', [CustomerController::class, 'editCustomer'])->name('editCustomer');
Route::post('/Customer/update/{id}', [CustomerController::class, 'updateCustomer'])->name('updateCustomer');
Route::get('/Customer/hapus/{id}', [CustomerController::class, 'hapusCustomer'])->name('hapusCustomer');
Route::post('/Customer/export', [CustomerController::class, 'exportCustomer'])->name('exportCustomer');


//====== Quotation (Sales) ========================================================================================
Route::get('/Quotation', [QuotationController::class, 'Quotation'])->name('Quotation');
Route::get('/Quotation/input', [QuotationController::class, 'inputQuotation'])->name('inputQuotation');
Route::post('/Quotation/post', [QuotationController::class, 'postQuotation'])->name('postQuotation');
Route::get('/Quotation/edit/{id}', [QuotationController::class, 'editQuotation'])->name('editQuotation');
Route::post('/Quotation/update/{id}', [QuotationController::class, 'updateQuotation'])->name('updateQuotation');
Route::get('/Quotation/hapus/{id}', [QuotationController::class, 'hapusQuotation'])->name('hapusQuotation');
Route::post('/Quotation/export', [QuotationController::class, 'exportQuotation'])->name('exportQuotation');
Route::post('/Quotation/send-email/{id}', [QuotationController::class, 'sendEmail'])->name('Quotation.sendEmail');

//======= Sales Order ===============================================================================================
Route::get('/SalesOrder', [SalesOrderController::class, 'SalesOrder'])->name('SalesOrder');
Route::get('/SalesOrder/edit/{id}', [SalesOrderController::class, 'editSalesOrder'])->name('editSalesOrder');
Route::post('/SalesOrder/update/{id}', [SalesOrderController::class, 'updateSalesOrder'])->name('updateSalesOrder');
Route::get('/SalesOrder/hapus/{id}', [SalesOrderController::class, 'hapusSalesOrder'])->name('hapusSalesOrder');
Route::post('/SalesOrder/export', [SalesOrderController::class, 'exportSalesOrder'])->name('exportSalesOrder');
Route::get('/a', [SalesOrderController::class, 'a'])->name('a');

//======= Sales Invoice ===============================================================================================
Route::get('/SalesInvoice', [SalesInvoiceController::class, 'SalesInvoice'])->name('SalesInvoice');
Route::get('/SalesInvoice/edit/{id}', [SalesInvoiceController::class, 'editSalesInvoice'])->name('editSalesInvoice');
Route::post('/SalesInvoice/update/{id}', [SalesInvoiceController::class, 'updateSalesInvoice'])->name('updateSalesInvoice');
Route::get('/SalesInvoice/hapus/{id}', [SalesInvoiceController::class, 'hapusSalesInvoice'])->name('hapusSalesInvoice');
Route::post('/SalesInvoice/export', [SalesInvoiceController::class, 'exportSalesInvoice'])->name('exportSalesInvoice');

//====== MO (Manufacturing Order) ========================================================================================
Route::get('/ManufacturingOrder', action: [ManufacturingOrderController::class, 'ManufacturingOrder'])->name('ManufacturingOrder');
Route::get('/ManufacturingOrder/hapus/{id}', [ManufacturingOrderController::class, 'hapusMO'])->name('hapusMO');
Route::post('/ManufacturingOrder/export', [ManufacturingOrderController::class, 'exportMO'])->name('exportMO');

// MO Get Data
Route::get('/get-bill-of-materials/{id}', [ManufacturingOrderController::class, 'getBillOfMaterials']);
Route::get('/get-bahan/{bill_of_material_id}', [ManufacturingOrderController::class, 'getBahanByBillOfMaterial']);
Route::get('/get-reference/{produk_id}', [ManufacturingOrderController::class, 'getReference']);
Route::get('/getBahanByProduk/{id}', [ManufacturingOrderController::class, 'getBahanByProduk']);

// MO Draft
Route::get('/ManufacturingOrder/openMO', [ManufacturingOrderController::class, 'draftManufacturingOrder'])->name('draftManufacturingOrder');
Route::post('/ManufacturingOrder/post', [ManufacturingOrderController::class, 'postdraftManufacturingOrder'])->name('postdraftManufacturingOrder');

// MO Confirmed
Route::get('/ManufacturingOrder/confirmed/{id}', [ManufacturingOrderController::class, 'confirmedMO'])->name('confirmedMO');
Route::get('/ManufacturingOrder/showConfirmedForm/{id}', [ManufacturingOrderController::class, 'showConfirmedForm'])->name('showConfirmedForm');
Route::post('/ManufacturingOrder/confirmed/{id}', [ManufacturingOrderController::class, 'postConfirmedForm'])->name('postConfirmedForm');

// MO CA
Route::get('/ManufacturingOrder/checkAvailability/{id}', [ManufacturingOrderController::class, 'checkAvailability'])->name('checkAvailability');
Route::get('/ManufacturingOrder/showcheckAvailabilityForm/{id}', [ManufacturingOrderController::class, 'showcheckAvailabilityForm'])->name('showcheckAvailabilityForm');
Route::post('/ManufacturingOrder/checkAvailability/{id}', [ManufacturingOrderController::class, 'postcheckAvailabilityForm'])->name('postcheckAvailabilityForm');

// Progress
Route::get('/ManufacturingOrder/progress/{id}', [ManufacturingOrderController::class, 'progress'])->name('progress');
Route::get('/ManufacturingOrder/showprogressForm/{id}', [ManufacturingOrderController::class, 'showprogressForm'])->name('showprogressForm');
Route::post('/ManufacturingOrder/progress/{id}', [ManufacturingOrderController::class, 'postprogressForm'])->name('postprogressForm');

// Done
Route::get('/ManufacturingOrder/done/{id}', [ManufacturingOrderController::class, 'done'])->name('done');
Route::get('/ManufacturingOrder/showdoneForm/{id}', [ManufacturingOrderController::class, 'showdoneForm'])->name('showdoneForm');
Route::post('/ManufacturingOrder/done/{id}', [ManufacturingOrderController::class, 'postdoneForm'])->name('postdoneForm');



//====== RequestForQuotation ========================================================================================

Route::get('/RequestForQuotation', [RequestForQuotationController::class, 'RequestForQuotation'])->name('RequestForQuotation');
Route::get('/RequestForQuotation/input', [RequestForQuotationController::class, 'inputRequestForQuotation'])->name('inputRequestForQuotation');
Route::post('/RequestForQuotation/post', [RequestForQuotationController::class, 'postRequestForQuotation'])->name('postRequestForQuotation');
Route::get('/RequestForQuotation/edit/{id}', [RequestForQuotationController::class, 'editRequestForQuotation'])->name('editRequestForQuotation');
Route::put('/RequestForQuotation/update/{id}', [RequestForQuotationController::class, 'updateRequestForQuotation'])->name('updateRequestForQuotation');
Route::delete('/RequestForQuotation/hapus/{id}', [RequestForQuotationController::class, 'hapus'])->name('RequestForQuotation.hapus');
Route::post('/RequestForQuotation/export', [RequestForQuotationController::class, 'exportRequestForQuotation'])->name('exportRequestForQuotation');
Route::post('/RequestForQuotation/{id}/done', [RequestForQuotationController::class, 'markAsDone'])->name('markAsDone');
Route::get('/RequestForQuotation/{id}/change-to-po', [RequestForQuotationController::class, 'changeStatusToPO'])->name('changeToPO');
Route::put('/RequestForQuotation/status/{id}', [RequestForQuotationController::class, 'updateStatus'])->name('updateStatus');
Route::put('/RequestForQuotation/updateStatus/{id}', [RequestForQuotationController::class, 'updateStatus'])->name('updateStatus');
Route::post('/RequestForQuotation/sendEmail/{id}', [RequestForQuotationController::class, 'sendEmail'])->name('sendEmailRFQ');


Route::post('/rfq/{id}/create-bill', [RequestForQuotationController::class, 'createBill'])->name('rfq.createBill');
Route::get('/rfq/draft-bills', [RequestForQuotationController::class, 'draftBills'])->name('rfq.draftBills');
Route::get('/rfq/{id}/bill-detail', [RequestForQuotationController::class, 'showBillDetail'])->name('rfq.showBillDetail');
Route::post('/rfq/{id}/confirm-bill', [RequestForQuotationController::class, 'confirmBill'])->name('rfq.confirmBill');
Route::post('/rfq/{id}/pay-bill', [RequestForQuotationController::class, 'payBill'])->name('rfq.payBill');

Route::get('/VendorBill', [RequestForQuotationController::class, 'vendorBillPage'])->name('vendorBill');


//====== PurchaseOrder ========================================================================================
Route::prefix('PurchaseOrder')->group(function () {
    Route::get('/', [RequestForQuotationController::class, 'PurchaseOrder'])->name('PurchaseOrder');
    Route::get('/input', [RequestForQuotationController::class, 'inputPurchaseOrder'])->name('inputPurchaseOrder');
    Route::post('/post', [RequestForQuotationController::class, 'postPurchaseOrder'])->name('postPurchaseOrder');
    Route::get('/detail/{id}', [RequestForQuotationController::class, 'detail'])->name('purchase_orders.detail');
    Route::post('/{id}/receive', [RequestForQuotationController::class, 'receiveProduct'])->name('purchase_orders.receive');
    Route::post('/{id}/create-bill', [RequestForQuotationController::class, 'createBill'])->name('purchase_orders.create_bill');
});
