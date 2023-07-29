<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bahan;
use App\Models\Barang;
use App\Models\Pesanan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use App\Models\PesananDetail;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //ambil tanggal hari ini
        $tgl_hariIni = now()->format('Y-m-d');
        //ambil tanggal awal dan akhir bulan
        $tgl_awalBulan = now()->startOfMonth();
        $tgl_akhirBulan = now()->endOfMonth();

        $pesanan_harian = Pesanan::whereDate('created_at', $tgl_hariIni)->count();
        $pesanan_bulanan = Pesanan::whereBetween('created_at', [$tgl_awalBulan, $tgl_akhirBulan])->count();

        // $pemasukan_harian = Pesanan::whereDate('created_at', $tgl_hariIni)->sum('bayar');
        // $pemasukan_bulanan = Pesanan::whereBetween('created_at', [$tgl_awalBulan, $tgl_akhirBulan])->sum('bayar');
        $pemasukan_harian = Pesanan::whereDate('created_at', $tgl_hariIni)
            ->where('status_pembayaran', 'lunas')
            ->sum('total');

        $pemasukan_bulanan = Pesanan::whereBetween('created_at', [$tgl_awalBulan, $tgl_akhirBulan])
            ->where('status_pembayaran', 'lunas')
            ->sum('total');


        $pengeluaran_harian = Pengeluaran::whereDate('created_at', $tgl_hariIni)->sum('total');
        $pengeluaran_bulanan = Pengeluaran::whereBetween('created_at', [$tgl_awalBulan, $tgl_akhirBulan])->sum('total');

        $desain_selesai = PesananDetail::whereBetween('created_at', [$tgl_awalBulan, $tgl_akhirBulan])->where('status_detail', '=', 'Sudah Ada Desain')->count();
        $desain_belum = PesananDetail::whereBetween('created_at', [$tgl_awalBulan, $tgl_akhirBulan])->where('status_detail', '=', 'Belum Ada Desain')->count();
        $pekerjaan_dikerjakan = PesananDetail::whereBetween('created_at', [$tgl_awalBulan, $tgl_akhirBulan])->where('status_detail', '=', 'Dikerjakan')->count();
        $pekerjaan_selesai = PesananDetail::whereBetween('created_at', [$tgl_awalBulan, $tgl_akhirBulan])->where('status_detail', '=', 'Selesai')->count();

        $totalbahan = PesananDetail::select(
            'pesanan_detail.id_bahan',
            'bahan.nama_bahan',
            'pesanan_detail.satuan',
            DB::raw('SUM(pesanan_detail.totalukuran) as total_keluar'),
            DB::raw('SUM(pesanan_detail.jumlah) as total_jumlah')
        )
            ->join('bahan', 'pesanan_detail.id_bahan', '=', 'bahan.id_bahan')
            ->whereBetween('pesanan_detail.created_at', [$tgl_awalBulan, $tgl_akhirBulan])
            ->groupBy('pesanan_detail.id_bahan', 'bahan.nama_bahan', 'pesanan_detail.satuan')
            ->get();

        //grafik pendapatan
        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-d');

        $data_tanggal = array();
        $data_pendapatan = array();

        while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
            $data_tanggal[] = (int) substr($tanggal_awal, 8, 2);

            // $total_pemasukan = Pesanan::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
            $total_pemasukan = Pesanan::where('created_at', 'LIKE', "%$tanggal_awal%")
                ->where('status_pembayaran', 'lunas')
                ->sum('total');
            $total_pengeluaran = Pengeluaran::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('total');

            $pendapatan = $total_pemasukan - $total_pengeluaran;
            $data_pendapatan[] += $pendapatan;

            $tanggal_awal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_awal)));
        }

        if (auth()->user()->id_level == 2) {
            return view('dashboard.manajer', compact(
                'tgl_awalBulan',
                'tgl_akhirBulan',
                'pesanan_harian',
                'pesanan_bulanan',
                'pemasukan_harian',
                'pemasukan_bulanan',
                'pengeluaran_harian',
                'pengeluaran_bulanan',
                'data_tanggal',
                'data_pendapatan',
                'desain_selesai',
                'desain_belum',
                'pekerjaan_dikerjakan',
                'pekerjaan_selesai',
                'totalbahan'
            ));
        } elseif (auth()->user()->id_level == 3) {
            return view('dashboard.desainer', compact(
                'tgl_awalBulan',
                'tgl_akhirBulan',
                'desain_selesai',
                'desain_belum',
                'pekerjaan_dikerjakan',
                'pekerjaan_selesai'
            ));
        } elseif (auth()->user()->id_level == 4) {
            return view('dashboard.kasir', compact(
                'tgl_awalBulan',
                'tgl_akhirBulan',
                'pesanan_harian',
                'pesanan_bulanan',
                'pemasukan_harian',
                'pemasukan_bulanan',
                'pengeluaran_harian',
                'pengeluaran_bulanan',
                'data_tanggal',
                'data_pendapatan',
                'totalbahan'
            ));
        } elseif (auth()->user()->id_level == 5) {
            return view('dashboard.operator', compact(
                'tgl_awalBulan',
                'tgl_akhirBulan',
                'desain_selesai',
                'desain_belum',
                'pekerjaan_dikerjakan',
                'pekerjaan_selesai'
            ));
        } else {
            return view('dashboard.index', compact(
                'tgl_awalBulan',
                'tgl_akhirBulan',
                'pesanan_harian',
                'pesanan_bulanan',
                'pemasukan_harian',
                'pemasukan_bulanan',
                'pengeluaran_harian',
                'pengeluaran_bulanan',
                'data_tanggal',
                'data_pendapatan',
                'desain_selesai',
                'desain_belum',
                'pekerjaan_dikerjakan',
                'pekerjaan_selesai',
                'totalbahan'
            ));
        }
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
