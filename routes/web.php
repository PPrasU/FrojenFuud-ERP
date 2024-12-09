<?php

use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\BillOfMaterialController;


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










