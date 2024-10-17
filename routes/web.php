<?php

use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\BahanController;

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

//====== BoM ========================================================================================
