<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PesananDetailController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengeluaranController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('administrator.dashboard');
// });

// Route::get('/produk', function () {
//     return view('administrator.produk');
// });
// Route::get('/master', [MasterController::class, 'index']);
// Route::post('/master/tambah-bahan', [MasterController::class, 'store_bahan'])->name('bahan.store');
// Route::get('/master/{id_bahan}/edit-bahan', [MasterController::class, 'show_bahan'])->name('bahan.show');
// Route::put('/master/{id_bahan}', [MasterController::class, 'update_bahan'])->name('bahan.update');

// Route::post('/master/tambah-mesin', [MasterController::class, 'store_mesin'])->name('mesin.store');
// Route::get('/master/{id_mesin}/edit-mesin', [MasterController::class, 'show_mesin'])->name('mesin.show');
// Route::put('/master/{id_mesin}', [MasterController::class, 'update_mesin'])->name('mesin.update');
// // Route::get('/hapus-bahan/{id_bahan}', 'MasterController@hapus_bmi');

Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::resource('/', DashboardController::class);

Route::resource('/mesin', MesinController::class);

Route::resource('/bahan', BahanController::class);

Route::resource('/barang', BarangController::class);

Route::resource('/karyawan', KaryawanController::class);

Route::get('/pesanan/create', [PesananController::class, 'create'])->name('pesanan.create');
Route::resource('/pesanan', PesananController::class)
    ->except('create');
    
Route::get('/pesanan_detail/loadform/{total}', [PesananDetailController::class, 'loadForm'])->name('pesanan_detail.load_form');
Route::resource('/pesanan_detail', PesananDetailController::class)
    ->except('create', 'show', 'edit');

Route::resource('/pengeluaran', PengeluaranController::class);

Route::resource('/laporan', LaporanController::class);
