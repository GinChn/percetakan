<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Pesanan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('laporan.index');
    }

    // tangkap tanggal
    public function handleForm(Request $request)
    {
        // ambil semua inputan
        $data_input_laporan = $request->all();
        $jenis_laporan = $data_input_laporan['jenis_laporan'];

        // cek milih laporan harian atau bulanan
        if ($jenis_laporan == "harian") {
            $tanggal_laporan = $data_input_laporan['tanggal_laporan'];

            $data_pemasukan = Pesanan::whereDate('created_at', $tanggal_laporan)
                ->where('status_pesanan', 'Selesai')
                ->get();
            $data_pengeluaran = Pengeluaran::whereDate('created_at', $tanggal_laporan)->get();
        } else if ($jenis_laporan == "bulanan") {
            $tanggal_laporan_awal = $data_input_laporan['tanggal_laporan_awal'];
            $tanggal_laporan_akhir = $data_input_laporan['tanggal_laporan_akhir'];

            $data_pemasukan = Pesanan::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(total) as total_tagihan')
            )
                ->whereRaw('DATE(created_at) BETWEEN ? AND ?', [$tanggal_laporan_awal, $tanggal_laporan_akhir])
                ->where('status_pesanan', 'Selesai')
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();

            $data_pengeluaran = Pengeluaran::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(total) as total_pengeluaran')
            )
                ->whereRaw('DATE(created_at) BETWEEN ? AND ?', [$tanggal_laporan_awal, $tanggal_laporan_akhir])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();
        }

        $data_laporan = [
            'data_masuk' => $data_pemasukan,
            'data_keluar' => $data_pengeluaran
        ];

        // kirim ke view data laporan yg sudah didapat beserta data inputan
        return view('laporan.index', ['data_laporan' => $data_laporan, 'data_input' => $data_input_laporan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
