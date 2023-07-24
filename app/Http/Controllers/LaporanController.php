<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExportView;
use Illuminate\Support\Facades\DB;
use App\Models\Pesanan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function handleForm(Request $request)
    {
        // ambil semua inputan
        $data_input_laporan = $request->all();
        $jenis_laporan = $data_input_laporan['jenis_laporan'];

        $data_laporan = $this->getQueryData($jenis_laporan, $data_input_laporan);

        // kirim ke view data laporan yg sudah didapat beserta data inputan
        return view('laporan.index', ['data_laporan' => $data_laporan, 'data_input' => $data_input_laporan]);
    }

    public function exportExcel(Request $request)
    {
        return $this->exportFile($request, 'xlsx');
    }

    public function exportPdf(Request $request)
    {
        return $this->exportFile($request, 'pdf');
    }

    private function exportFile(Request $request, $format)
    {
        // ambil semua inputan
        $data_input_laporan = $request->all();
        $jenis_laporan = $data_input_laporan['jenis_laporan'] ?? null;

        // Check if the necessary date keys exist in the array
        $tanggal_laporan = $data_input_laporan['tanggal_laporan'] ?? null;
        $tanggal_laporan_awal = $data_input_laporan['tanggal_laporan_awal'] ?? null;
        $tanggal_laporan_akhir = $data_input_laporan['tanggal_laporan_akhir'] ?? null;

        // Perform further validation if needed
        if ($jenis_laporan === null) {
            return redirect()->back()->with('gagal-export', 'Jenis laporan belum dipilih.');
        }

        if ($jenis_laporan === 'harian' && $tanggal_laporan === null) {
            return redirect()->back()->with('gagal-export', 'Tanggal laporan harian belum dipilih.');
        }

        if ($jenis_laporan === 'bulanan' && ($tanggal_laporan_awal === null || $tanggal_laporan_akhir === null)) {
            return redirect()->back()->with('gagal-export', 'Periode laporan bulanan belum dipilih.');
        }

        $data_laporan = $this->getQueryData($jenis_laporan, $data_input_laporan);
        $nama_file = $this->generateFileName($jenis_laporan, $tanggal_laporan, $tanggal_laporan_awal, $tanggal_laporan_akhir, $format);

        if ($format === 'xlsx') {
            $laporanExport = new LaporanExportView($data_laporan, $data_input_laporan);
            return Excel::download($laporanExport, $nama_file);
        } elseif ($format === 'pdf') {
            $pdf = Pdf::loadView('laporan.laporanpdf', ['data_laporan' => $data_laporan, 'data_input' => $data_input_laporan]);

            return $pdf->download($nama_file);
        }

        return redirect()->back()->with('error', 'Format file tidak didukung.');
    }

    private function getQueryData($jenis_laporan, $data_input_laporan)
    {
        $data_pemasukan = [];
        $data_pengeluaran = [];
        $total_bersih = null;

        if ($jenis_laporan == "harian") {
            $tanggal_laporan = $data_input_laporan['tanggal_laporan'];

            $data_pemasukan = Pesanan::whereDate('created_at', $tanggal_laporan)
                ->where('status_pembayaran', 'Lunas')
                ->get();
            $data_pengeluaran = Pengeluaran::whereDate('created_at', $tanggal_laporan)->get();

            $total_pemasukan = Pesanan::select(
                DB::raw('SUM(total) as total_pemasukan')
            )
                ->whereDate('created_at', $tanggal_laporan)
                ->where('status_pembayaran', 'Lunas')
                ->groupBy(DB::raw('DATE(created_at)'))
                ->first();
            if ($total_pemasukan) {
                $total_pemasukan = $total_pemasukan->total_pemasukan;
            } else {
                $total_pemasukan = 0;
            }

            $total_pengeluaran = Pengeluaran::select(
                DB::raw('SUM(total) as total_pengeluaran')
            )
                ->whereDate('created_at', $tanggal_laporan)
                ->groupBy(DB::raw('DATE(created_at)'))
                ->first();
            if ($total_pengeluaran) {
                $total_pengeluaran = $total_pengeluaran->total_pengeluaran;
            } else {
                $total_pengeluaran = 0;
            }

            // Lakukan pengurangan
            $total_bersih = $total_pemasukan - $total_pengeluaran;
        } else if ($jenis_laporan == "bulanan") {
            $tanggal_laporan_awal = $data_input_laporan['tanggal_laporan_awal'];
            $tanggal_laporan_akhir = $data_input_laporan['tanggal_laporan_akhir'];

            $data_pemasukan = Pesanan::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(total) as total_tagihan')
            )
                ->whereRaw('DATE(created_at) BETWEEN ? AND ?', [$tanggal_laporan_awal, $tanggal_laporan_akhir])
                ->where('status_pembayaran', 'Lunas')
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
                ->where('status_pembayaran', 'Lunas')
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

        return $data_laporan;
    }

    private function generateFileName($jenis_laporan, $tanggal_laporan, $tanggal_laporan_awal, $tanggal_laporan_akhir, $format)
    {
        if ($jenis_laporan == 'harian') {
            $tanggal_laporan_name = date('d-m-Y', strtotime($tanggal_laporan));
            $nama_file = 'laporan_' . $jenis_laporan . '_' . $tanggal_laporan_name . '.' . $format;
        } elseif ($jenis_laporan == 'bulanan') {
            $tanggal_laporan_awal_name = date('d-m-Y', strtotime($tanggal_laporan_awal));
            $tanggal_laporan_akhir_name = date('d-m-Y', strtotime($tanggal_laporan_akhir));
            $nama_file = 'laporan_periode' . '_' . $tanggal_laporan_awal_name . '_sampai_' . $tanggal_laporan_akhir_name . '.' . $format;
        }

        return $nama_file;
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
