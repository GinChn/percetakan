<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PekerjaanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PesananDetailController;
use App\Http\Controllers\StatusController;

use App\Http\Middleware\CekRole;

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
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);
Route::get('/reset-password', [LoginController::class, 'resetPassword']);


Route::group(['middleware' => 'auth'], function () {
    // yg sudah login biasa akses:
    Route::resource('/dashboard', DashboardController::class);

    // yg role administrator bisa akses:
    Route::group(['middleware' => ['cekrole:Administrator']], function () {
        Route::resource('/registrasi', RegistrasiController::class);
        Route::resource('/mesin', MesinController::class);
        Route::resource('/bahan', BahanController::class);
        Route::resource('/barang', BarangController::class);
        Route::resource('/karyawan', KaryawanController::class);
        Route::resource('/pesanan', PesananController::class);
        Route::get('/pesanan_detail/loadbarang', [PesananDetailController::class, 'loadBarang'])->name('pesanan_detail.barang');
        Route::delete('/pesanan_detail/{id}/batal_pesanan', [PesananDetailController::class, 'batalPesanan'])->name('batal.pesanan');
        Route::resource('/pesanan_detail', PesananDetailController::class)
            ->except('create');
        Route::resource('/pembayaran', PembayaranController::class);
        Route::get('/pembayaran/{id}/bayar', [PembayaranController::class, 'pembayaran'])->name('bayar.pesanan');
        Route::get('/pembayaran/{id}/nota', [PembayaranController::class, 'nota'])->name('pembayaran.nota');
        Route::resource('/pekerjaan', PekerjaanController::class);
        Route::resource('/laporan', LaporanController::class);
        Route::post('/laporan', [LaporanController::class, 'handleForm'])->name('submit_tanggal');
        Route::get('/export-excel', [LaporanController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export-pdf', [LaporanController::class, 'exportPdf'])->name('export.pdf');
    });

    // yg role manajer bisa akses:
    Route::group(['middleware' => ['cekrole:Manajer']], function () {
        Route::resource('/pesanan', PesananController::class);
        Route::resource('/laporan', LaporanController::class);
        Route::post('/laporan', [LaporanController::class, 'handleForm'])->name('submit_tanggal');
        //export excel
        Route::get('/export-excel', [LaporanController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export-pdf', [LaporanController::class, 'exportPdf'])->name('export.pdf');
    });

    // yg role desainer bisa akses:
    Route::group(['middleware' => ['cekrole:Desainer']], function () {
        Route::resource('/pesanan', PesananController::class);
        Route::get('/pesanan_detail/loadbarang', [PesananDetailController::class, 'loadBarang'])->name('pesanan_detail.barang');
        Route::delete('/pesanan_detail/{id}/batal_pesanan', [PesananDetailController::class, 'batalPesanan'])->name('batal.pesanan');
        Route::resource('/pesanan_detail', PesananDetailController::class)
            ->except('create');
        Route::resource('/pekerjaan', PekerjaanController::class);
    });

    // yg role kasir bisa akses:
    Route::group(['middleware' => ['cekrole:Kasir']], function () {
        Route::resource('/pesanan', PesananController::class);
        Route::resource('/mesin', MesinController::class);
        Route::resource('/bahan', BahanController::class);
        Route::resource('/barang', BarangController::class);
        Route::resource('/karyawan', KaryawanController::class);
        Route::resource('/pembayaran', PembayaranController::class);
        Route::get('/pembayaran/{id}/bayar', [PembayaranController::class, 'pembayaran'])->name('bayar.pesanan');
        Route::get('/pembayaran/{id}/nota', [PembayaranController::class, 'nota'])->name('pembayaran.nota');
        Route::resource('/pekerjaan', PekerjaanController::class);
        Route::resource('/pengeluaran', PengeluaranController::class);
    });

    // yg role operator bisa akses:
    Route::group(['middleware' => ['cekrole:Operator']], function () {
        Route::resource('/pesanan', PesananController::class);
        Route::resource('/pekerjaan', PekerjaanController::class);
    });
});
