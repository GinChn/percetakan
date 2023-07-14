<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExportView;
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
        $total_bersih = null;

        // cek milih laporan harian atau bulanan
        if ($jenis_laporan == "harian") {
            $tanggal_laporan = $data_input_laporan['tanggal_laporan'];

            $data_pemasukan = Pesanan::whereDate('created_at', $tanggal_laporan)
                ->where('status_pesanan', 'Selesai')
                ->get();
            $data_pengeluaran = Pengeluaran::whereDate('created_at', $tanggal_laporan)->get();

            $total_pemasukan = Pesanan::select(
                DB::raw('SUM(total) as total_pemasukan_harian')
            )
                ->whereDate('created_at', $tanggal_laporan)
                ->where('status_pesanan', 'Selesai')
                ->groupBy(DB::raw('DATE(created_at)'))
                ->first();

            $total_pengeluaran = Pengeluaran::select(
                DB::raw('SUM(total) as total_pengeluaran_harian')
            )
                ->whereDate('created_at', $tanggal_laporan)
                ->groupBy(DB::raw('DATE(created_at)'))
                ->first();

            if ($total_pemasukan && $total_pengeluaran) {
                $total_bersih = $total_pemasukan->total_pemasukan_harian - $total_pengeluaran->total_pengeluaran_harian;
            }
            // $total_bersih = $total_pemasukan->total_pemasukan_harian - $total_pengeluaran->total_pengeluaran_harian;
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

            $total_pemasukan = Pesanan::whereBetween(
                DB::raw('DATE(created_at)'),
                [$tanggal_laporan_awal, $tanggal_laporan_akhir]
            )
                ->where('status_pesanan', 'Selesai')
                ->sum('total');

            $total_pengeluaran = Pengeluaran::whereBetween(
                DB::raw('DATE(created_at)'),
                [$tanggal_laporan_awal, $tanggal_laporan_akhir]
            )
                ->sum('total');
            $total_bersih = $total_pemasukan - $total_pengeluaran;
        }

        $data_laporan = [
            'data_masuk' => $data_pemasukan,
            'data_keluar' => $data_pengeluaran,
            'total_masuk' => $total_pemasukan,
            'total_keluar' => $total_pengeluaran,
            'total_bersih' => $total_bersih
        ];

        $request->session()->put('data_laporan', $data_laporan);
        $request->session()->put('data_input', $data_input_laporan);


        // kirim ke view data laporan yg sudah didapat beserta data inputan
        return view('laporan.index', ['data_laporan' => $data_laporan, 'data_input' => $data_input_laporan]);
    }

    public function exportExcel(Request $request)
    {
        $data_laporan = $request->session()->get('data_laporan');
        $data_input_laporan = $request->session()->get('data_input');


        // Membuat instance LaporanExportView dengan data yang diperlukan
        $laporanExport = new LaporanExportView($data_laporan, $data_input_laporan);

        // Menggunakan Laravel-Excel untuk melakukan export
        return Excel::download($laporanExport, 'laporan.xlsx');
    }

    // public function exportexcel()
    // {
    //     return Excel::download(new LaporanExport, 'laporan.xlsx');
    // }

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
