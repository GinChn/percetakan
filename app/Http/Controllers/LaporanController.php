<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use App\Models\PesananDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanExportView;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil data_laporan dan data_input dari sesi jika tersedia
        $data_laporan = session('data_laporan');
        $data_input = session('data_input');

        // Cek apakah data_laporan kosong
        if (empty($data_laporan)) {
            // Atur nilai default atau kosongkan variabel jika sesuai dengan kebutuhan
            $data_laporan = []; // Contoh: set data_laporan sebagai array kosong
        }

        // Cek apakah data_input kosong
        if (empty($data_input)) {
            // Atur nilai default atau kosongkan variabel jika sesuai dengan kebutuhan
            $data_input = []; // Contoh: set data_input sebagai array kosong
        }

        return view('laporan.index', compact('data_laporan', 'data_input'));
    }
    public function pesananPeriode(Request $request)
    {
        $tanggal = $request->input('tanggal');

        $tanggal = Carbon::parse($tanggal);

        $pesanan = Pesanan::whereDate('created_at', $tanggal)
            ->where('status_pembayaran', 'Lunas')
            ->orderBy('no_nota', 'desc')
            ->get();

        return view('laporan.pesanan_periode', [
            'tanggal' => $tanggal,
            'pesanan' => $pesanan,
        ]);
    }
    public function pengeluaranPeriode(Request $request)
    {
        $tanggal = $request->input('tanggal');

        $tanggal = Carbon::parse($tanggal);

        $pengeluaran = Pengeluaran::whereDate('created_at', $tanggal)
            ->where('status_pengeluaran', 'Disetujui')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('laporan.pengeluaran_periode', [
            'pengeluaran' => $pengeluaran,
            'tanggal' => $tanggal,

        ]);
    }

    public function cekLaporan(Request $request)
    {
        // Validasi inputan sebelum diproses dengan pesan error kustom
        $validator = Validator::make($request->all(), [
            'tanggal_laporan' => 'required_if:jenis_laporan,harian',
            'tanggal_laporan_awal' => 'required_if:jenis_laporan,bulanan',
            'tanggal_laporan_akhir' => 'required_if:jenis_laporan,bulanan',
        ], [
            'tanggal_laporan.required_if' => 'Tanggal laporan harus diisi untuk laporan harian.',
            'tanggal_laporan_awal.required_if' => 'Tanggal laporan awal harus diisi untuk laporan bulanan.',
            'tanggal_laporan_akhir.required_if' => 'Tanggal laporan akhir harus diisi untuk laporan bulanan.',
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            Session::flash('gagal-export', $validator->errors()->first()); // Mengatur pesan error pada Session
            return redirect()->back()->withInput();
        }

        // Ambil semua inputan
        $data_input_laporan = $request->all();
        $jenis_laporan = $data_input_laporan['jenis_laporan'];

        $data_laporan = $this->getQueryData($jenis_laporan, $data_input_laporan);

        // Simpan data dalam session dan redirect
        session()->put('data_laporan', $data_laporan);
        session()->put('data_input', $data_input_laporan);

        return redirect()->route('laporan.index');
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
            $data_pengeluaran = Pengeluaran::whereDate('created_at', $tanggal_laporan)
                ->where('status_pengeluaran', 'Disetujui')
                ->get();

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
                ->where('status_pengeluaran', 'Disetujui')
                ->groupBy(DB::raw('DATE(created_at)'))
                ->first();
            if ($total_pengeluaran) {
                $total_pengeluaran = $total_pengeluaran->total_pengeluaran;
            } else {
                $total_pengeluaran = 0;
            }

            // Lakukan pengurangan
            $total_bersih = $total_pemasukan - $total_pengeluaran;

            // dapatkan jumlah bahan keluar harian
            $total_bahan = PesananDetail::select(
                'pesanan_detail.id_bahan',
                'bahan.nama_bahan',
                'pesanan_detail.satuan',
                DB::raw('SUM(pesanan_detail.totalukuran) as total_keluar'),
                DB::raw('SUM(pesanan_detail.jumlah) as total_jumlah')
            )
                ->join('bahan', 'pesanan_detail.id_bahan', '=', 'bahan.id_bahan')
                ->whereDate('pesanan_detail.created_at', $tanggal_laporan)
                ->groupBy('pesanan_detail.id_bahan', 'bahan.nama_bahan', 'pesanan_detail.satuan')
                ->get();
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
                ->where('status_pengeluaran', 'Disetujui')
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
            )->where('status_pengeluaran', 'Disetujui')
                ->sum('total');
            $total_bersih = $total_pemasukan - $total_pengeluaran;

            // dapatkan jumlah bahan keluar bulanan
            $total_bahan = PesananDetail::select(
                'pesanan_detail.id_bahan',
                'bahan.nama_bahan',
                'pesanan_detail.satuan',
                DB::raw('SUM(pesanan_detail.totalukuran) as total_keluar'),
                DB::raw('SUM(pesanan_detail.jumlah) as total_jumlah')
            )
                ->join('bahan', 'pesanan_detail.id_bahan', '=', 'bahan.id_bahan')
                ->whereRaw('DATE(pesanan_detail.created_at) BETWEEN ? AND ?', [$tanggal_laporan_awal, $tanggal_laporan_akhir])
                ->groupBy('pesanan_detail.id_bahan', 'bahan.nama_bahan', 'pesanan_detail.satuan')
                ->get();
        }

        $data_laporan = [
            'data_masuk' => $data_pemasukan,
            'data_keluar' => $data_pengeluaran,
            'total_masuk' => $total_pemasukan,
            'total_keluar' => $total_pengeluaran,
            'total_bersih' => $total_bersih,
            'total_bahan' => $total_bahan
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

    public function show(Request $request, $id)
    {
        // Mendapatkan URL sebelumnya (referer)
        $referer = $request->headers->get('referer');



        return view('laporan.detail_pesanan', [
            'data' => Pesanan::where('id_pesanan', $id)->get(),
            'detail' => DB::table('pesanan_detail')
                ->join('barang', 'pesanan_detail.id_barang', '=', 'barang.id_barang')
                ->join('finishing', 'pesanan_detail.id_finishing', '=', 'finishing.id_finishing')
                ->where('id_pesanan', $id)
                ->get()
        ]);
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
