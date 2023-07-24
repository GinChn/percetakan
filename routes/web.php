<?php

use App\Http\Middleware\CekRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PekerjaanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\RegistrasiController;

use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PesananDetailController;

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
Route::resource('/', StatusController::class);
Route::resource('/cek-pesanan', StatusController::class);
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/reset-password', [LoginController::class, 'resetPassword']);


Route::group(['middleware' => 'auth'], function () {
    // yg sudah login biasa akses:
    Route::get('/logout', [LoginController::class, 'logout']);
    Route::resource('/profile', ProfileController::class);
    Route::resource('/dashboard', DashboardController::class);
    Route::resource('/pekerjaan', PekerjaanController::class);

    // yg role administrator bisa akses:
    // Route::group(['middleware' => ['cekrole:Administrator']], function () {
    //     Route::resource('/registrasi', RegistrasiController::class);
    //     Route::resource('/mesin', MesinController::class);
    //     Route::resource('/bahan', BahanController::class);
    //     Route::resource('/barang', BarangController::class);
    //     Route::resource('/karyawan', KaryawanController::class);
    //     Route::get('/pesanan_detail/loadbarang', [PesananDetailController::class, 'loadBarang'])->name('pesanan_detail.barang');
    //     Route::delete('/pesanan_detail/{id}/batal_pesanan', [PesananDetailController::class, 'batalPesanan'])->name('batal.pesanan');
    //     Route::resource('/pesanan_detail', PesananDetailController::class)
    //         ->except('create');
    //     Route::resource('/pesanan', PesananController::class);
    //     Route::resource('/pembayaran', PembayaranController::class);
    //     Route::get('/pembayaran/{id}/bayar', [PembayaranController::class, 'pembayaran'])->name('bayar.pesanan');
    //     Route::get('/pembayaran/{id}/nota', [PembayaranController::class, 'nota'])->name('pembayaran.nota');
    //     Route::resource('/pekerjaan', PekerjaanController::class);
    //     Route::resource('/laporan', LaporanController::class);
    //     Route::post('/laporan', [LaporanController::class, 'handleForm'])->name('submit_tanggal');
    //     Route::get('/export-excel', [LaporanController::class, 'exportExcel'])->name('export.excel');
    //     Route::get('/export-pdf', [LaporanController::class, 'exportPdf'])->name('export.pdf');
    // });
    Route::group(['middleware' => ['cekrole:Administrator,Desainer,Operator,Kasir']], function () {
        Route::resource('/pesanan', PesananController::class);
        Route::get('/pesanan_detail/loadbarang', [PesananDetailController::class, 'loadBarang'])->name('pesanan_detail.barang');
    });


    Route::group(['middleware' => ['cekrole:Administrator,Kasir,Manajer']], function () {
        Route::resource('/laporan', LaporanController::class);
        Route::post('/laporan', [LaporanController::class, 'handleForm'])->name('submit_tanggal');
        Route::get('/export-excel', [LaporanController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export-pdf', [LaporanController::class, 'exportPdf'])->name('export.pdf');
    });


    // yg role desainer bisa akses:
    Route::group(['middleware' => ['cekrole:Administrator,Desainer']], function () {
        Route::get('/pesanan_detail/loadbarang', [PesananDetailController::class, 'loadBarang'])->name('pesanan_detail.barang');
        Route::delete('/pesanan_detail/{id}/batal_pesanan', [PesananDetailController::class, 'batalPesanan'])->name('batal.pesanan');
        Route::resource('/pesanan_detail', PesananDetailController::class)
            ->except('create');
    });

    // yg role kasir bisa akses:
    Route::group(['middleware' => ['cekrole:Administrator,Kasir']], function () {
        Route::resource('/registrasi', RegistrasiController::class);
        Route::resource('/mesin', MesinController::class);
        Route::resource('/bahan', BahanController::class);
        Route::resource('/barang', BarangController::class);
        Route::resource('/karyawan', KaryawanController::class);
        Route::resource('/pembayaran', PembayaranController::class);
        Route::get('/pembayaran/{id}/bayar', [PembayaranController::class, 'pembayaran'])->name('bayar.pesanan');
        Route::get('/pembayaran/{id}/nota', [PembayaranController::class, 'nota'])->name('pembayaran.nota');
        Route::resource('/pengeluaran', PengeluaranController::class);
    });
});
