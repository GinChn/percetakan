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
        $jenis_laporan = $request->query('jenis_laporan');
        $tanggal_laporan = $request->query('tanggal_laporan');
        $tanggal_laporan_awal = $request->query('tanggal_laporan_awal');
        $tanggal_laporan_akhir = $request->query('tanggal_laporan_akhir');

        $data_laporan = $this->getQueryData($jenis_laporan, $tanggal_laporan, $tanggal_laporan_awal, $tanggal_laporan_akhir);

        $data_input = [
            'jenis_laporan' => $jenis_laporan,
            'tanggal_laporan' => $tanggal_laporan,
            'tanggal_laporan_awal' => $tanggal_laporan_awal,
            'tanggal_laporan_akhir' => $tanggal_laporan_akhir
        ];

        $nama_file = $this->generateFileName($jenis_laporan, $tanggal_laporan, $tanggal_laporan_awal, $tanggal_laporan_akhir, $format);

        if ($format === 'xlsx') {
            $laporanExport = new LaporanExportView($data_laporan, $data_input);
            return Excel::download($laporanExport, $nama_file);
        } elseif ($format === 'pdf') {
            $pdf = Pdf::loadView('laporan.laporanpdf', compact('data_laporan', 'data_input'));
            return $pdf->download($nama_file);
        }

        return redirect()->back()->with('error', 'Format file tidak didukung.');
    }

    private function getQueryData($jenis_laporan, $tanggal_laporan, $tanggal_laporan_awal, $tanggal_laporan_akhir)
    {
        $query_pemasukan = Pesanan::where('status_pesanan', 'Selesai');
        $query_pengeluaran = Pengeluaran::query();

        if ($jenis_laporan == "harian") {
            $query_pemasukan->whereDate('created_at', $tanggal_laporan);
            $query_pengeluaran->whereDate('created_at', $tanggal_laporan);
        } elseif ($jenis_laporan == "bulanan") {
            $query_pemasukan->whereBetween('created_at', [$tanggal_laporan_awal, $tanggal_laporan_akhir]);
            $query_pengeluaran->whereBetween('created_at', [$tanggal_laporan_awal, $tanggal_laporan_akhir]);
        }

        $data_pemasukan = $query_pemasukan->get();
        $data_pengeluaran = $query_pengeluaran->get();

        $total_pemasukan = Pesanan::select(
            DB::raw('SUM(total) as total_pemasukan_harian')
        )
            ->where('status_pesanan', 'Selesai')
            ->when($jenis_laporan == "harian", function ($query) use ($tanggal_laporan) {
                $query->whereDate('created_at', $tanggal_laporan)
                    ->groupBy(DB::raw('DATE(created_at)'));
            })
            ->first();

        $total_pengeluaran = Pengeluaran::select(
            DB::raw('SUM(total) as total_pengeluaran_harian')
        )
            ->when($jenis_laporan == "harian", function ($query) use ($tanggal_laporan) {
                $query->whereDate('created_at', $tanggal_laporan)
                    ->groupBy(DB::raw('DATE(created_at)'));
            })
            ->first();

        $total_bersih = $total_pemasukan ? $total_pemasukan->total_pemasukan_harian : 0;
        $total_bersih -= $total_pengeluaran ? $total_pengeluaran->total_pengeluaran_harian : 0;

        return [
            'data_masuk' => $data_pemasukan,
            'data_keluar' => $data_pengeluaran,
            'total_masuk' => $total_pemasukan,
            'total_keluar' => $total_pengeluaran,
            'total_bersih' => $total_bersih
        ];
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
