<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LaporanController;
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

Route::resource('/', DashboardController::class);
Route::resource('/produk', ProdukController::class);
Route::resource('/karyawan', KaryawanController::class);
Route::resource('/pengeluaran', PengeluaranController::class);
Route::resource('/laporan', LaporanController::class);
