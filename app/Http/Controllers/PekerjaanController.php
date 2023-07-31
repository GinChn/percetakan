<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PesananDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $progresPesanan = $this->getProgresPesanan();

        return view('pekerjaan.index', compact('progresPesanan'));
    }

    public function pekerjaanDetail(Request $request, $id)
    {
        // Mendapatkan URL sebelumnya (referer)
        $referer = $request->headers->get('referer');

        // Cek apakah URL sebelumnya mengandung '/pekerjaan'
        $tampilUbah = false;
        if ($referer && strpos($referer, '/pekerjaan') !== false) {
            $tampilUbah = true;
        }

        return view('pekerjaan.detail_status', [
            'tampilUbah' => $tampilUbah,
            'data' => Pesanan::where('id_pesanan', $id)->get(),
            'detail' => DB::table('pesanan_detail')
                ->join('barang', 'pesanan_detail.id_barang', '=', 'barang.id_barang')
                ->join('finishing', 'pesanan_detail.id_finishing', '=', 'finishing.id_finishing')
                ->where('id_pesanan', $id)
                ->get()
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $statusDetail = $request->input('status_detail');
            $statusText = $this->getStatusValue($statusDetail); // Call getStatusValue function

            $pesananDetail = PesananDetail::findOrFail($id);

            // Jika status_detail yang diupdate adalah 'Dikerjakan'
            if ($statusText === 'Dikerjakan') {
                // Mengambil nama user yang sedang login
                $operator = auth()->user()->nama;

                // Memperbarui status_detail dan operator
                $pesananDetail->update([
                    'status_detail' => $statusText,
                    'operator' => $operator,
                ]);
            } else {
                // Jika status_detail bukan 'Dikerjakan', hanya update status_detail
                $pesananDetail->update(['status_detail' => $statusText]);
            }

            return back()->with('status', 'Berhasil update status item pesanan!');
        } catch (ModelNotFoundException $exception) {
            return back()->withErrors('Record not found.');
        }
    }

    public function updateStatusDiambilAll(Request $request)
    {
        $ids = $request->input('ids');
        Pesanan::whereIn('id_pesanan', $ids)
            ->update(['status_pesanan' => 'Sudah Diambil']);

        return response()->json(['message' => 'Data updated successfully']);
    }
    public function updateStatusDiambil($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update(['status_pesanan' => 'Sudah Diambil']);

        return back()->with('status', 'Berhasil update status pesanan!');
    }

    public function updateStatusAll2(Request $request) // update status_detail sekaligus ke Sudah Ada Desain
    {
        $ids = $request->input('ids');
        PesananDetail::whereIn('id_pesanan_detail', $ids)
            ->update(['status_detail' => 'Sudah Ada Desain']);

        return response()->json(['message' => 'Data updated successfully']);
    }
    public function updateStatusAll3(Request $request) // update status_detail sekaligus ke Dikerjakan
    {
        $ids = $request->input('ids');
        $operator = auth()->user()->nama;
        PesananDetail::whereIn('id_pesanan_detail', $ids)
            ->update([
                'status_detail' => 'Dikerjakan',
                'operator' => $operator, // Memasukkan nama user yang sedang login ke dalam kolom 'operator'
            ]);

        return response()->json(['message' => 'Data updated successfully']);
    }

    public function updateStatusAll4(Request $request) // update status_detail sekaligus ke Selesai
    {
        $ids = $request->input('ids');
        PesananDetail::whereIn('id_pesanan_detail', $ids)
            ->update(['status_detail' => 'Selesai']);

        return response()->json(['message' => 'Data updated successfully']);
    }

    public function belumAdaDesain() // tampil semua item pesanan detail Belum Ada Desain
    {
        $data = PesananDetail::select('*')
            ->join('finishing', 'pesanan_detail.id_finishing', '=', 'finishing.id_finishing')
            ->join('barang', 'pesanan_detail.id_barang', '=', 'barang.id_barang')
            ->join('pesanan', 'pesanan_detail.id_pesanan', '=', 'pesanan.id_pesanan')
            ->where('status_detail', 'Belum Ada Desain')
            ->orderby('pesanan.created_at')
            ->get();
        return view('pekerjaan.belum_ada_desain', ['data' => $data]);
    }

    public function sudahAdaDesain() // tampil semua item pesanan detail Sudah Ada Desain
    {
        $data = PesananDetail::select('*')
            ->join('finishing', 'pesanan_detail.id_finishing', '=', 'finishing.id_finishing')
            ->join('barang', 'pesanan_detail.id_barang', '=', 'barang.id_barang')
            ->join('pesanan', 'pesanan_detail.id_pesanan', '=', 'pesanan.id_pesanan')
            ->where('status_detail', 'Sudah Ada Desain')
            ->orderby('pesanan.created_at')
            ->get();
        return view('pekerjaan.sudah_ada_desain', ['data' => $data]);
    }
    public function dikerjakan() // tampil semua item pesanan detail status Dikerjakan
    {
        $data = PesananDetail::select('*')
            ->join('finishing', 'pesanan_detail.id_finishing', '=', 'finishing.id_finishing')
            ->join('barang', 'pesanan_detail.id_barang', '=', 'barang.id_barang')
            ->join('pesanan', 'pesanan_detail.id_pesanan', '=', 'pesanan.id_pesanan')
            ->where('status_detail', 'Dikerjakan')
            ->orderby('pesanan.created_at')
            ->get();
        return view('pekerjaan.dikerjakan', ['data' => $data]);
    }

    public function selesaiStatusDetail() // tampil semua 
    {
        $data = PesananDetail::select('*')
            ->join('finishing', 'pesanan_detail.id_finishing', '=', 'finishing.id_finishing')
            ->join('barang', 'pesanan_detail.id_barang', '=', 'barang.id_barang')
            ->join('pesanan', 'pesanan_detail.id_pesanan', '=', 'pesanan.id_pesanan')
            ->where('status_detail', 'Selesai')
            ->orderby('pesanan.created_at')
            ->get();
        return view('pekerjaan.selesai_status_detail', ['data' => $data]);
    }


    public function selesaiPesanan() // tampil semua pesanan dengan status Selesai
    {
        $pesananSelesai = Pesanan::where('status_pesanan', 'Selesai')->get();
        return view('pekerjaan.selesai', ['data' => $pesananSelesai]);
    }

    public function sudahDiambil() // tampil semua pesanan dengan status Selesai
    {
        $data = Pesanan::where('status_pesanan', 'Sudah Diambil')->get();
        return view('pekerjaan.sudah_diambil', ['data' => $data]);
    }


    protected function getStatusValue($statusDetail)
    {
        switch ($statusDetail) {
            case "1":
                return "Belum Ada Desain";
            case "2":
                return "Sudah Ada Desain";
            case "3":
                return "Dikerjakan";
            case "4":
                return "Selesai";
            default:
                return "Unknown Status";
        }
    }


    private function getProgresPesanan()
    {
        $progresPesanan = Pesanan::leftJoin('pesanan_detail', 'pesanan.id_pesanan', '=', 'pesanan_detail.id_pesanan')
            ->select(
                'pesanan.id_pesanan',
                'pesanan.no_nota',
                'pesanan.nama_pelanggan',
                'pesanan.created_at',
                DB::raw('COUNT(pesanan_detail.id_pesanan) as banyak_status_detail'),
                DB::raw('SUM(CASE WHEN pesanan_detail.status_detail = "Selesai" THEN 1 ELSE 0 END) as banyak_status_selesai')
            )
            ->where('status_pesanan', '<>', 'Sudah Diambil')
            ->groupBy('pesanan.id_pesanan', 'pesanan.no_nota', 'pesanan.nama_pelanggan', 'pesanan.created_at')
            ->get();

        $progresPesanan->transform(function ($item) {
            $item->progres = ($item->banyak_status_detail == 0) ? 0 : ($item->banyak_status_selesai / $item->banyak_status_detail) * 100;
            return $item;
        });

        return $progresPesanan;
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
