<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Models\PesananDetail;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pesanan.index', [
            'pesanan' => Pesanan::orderBy('no_nota', 'desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Variabelkan tanggal saat ini
        $now = Carbon::now();

        // Ambil tanggal dan bulan saat ini
        $thnBulan = $now->year . $now->month;

        // cek data di tabel pesanan untuk autonumbering nomor nota
        $cek = Pesanan::count();
        if ($cek == 0) {
            $urut = 10001;
            $no_nota = 'NT' . $thnBulan . $urut;
        } else {
            $ambil = Pesanan::all()->last();
            $urut = (int)substr($ambil->no_nota, -5) + 1;
            $no_nota = 'NT' . $thnBulan . $urut;
        }

        // kirim no nota ke tabel pesanna
        $pesanan = Pesanan::create([
            'no_nota' => $no_nota
        ]);

        session(['id_pesanan' => $pesanan->id_pesanan]);

        return redirect('/pesanan_detail');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
        ]);
        Pesanan::FindorFail($request->id_pesanan)->update([
            'nama_pelanggan' => $request->nama_pelanggan,
            'no_telp' => $request->no_telp,
            'total' => $request->total,
            'total_biaya_desain' => $request->total_biaya_desain,
            'grand_total' => $request->grand_total,
            'status_pembayaran' => 'Menunggu Pembayaran',
            'status_pesanan' => 'Dalam Proses'
        ]);

        return redirect('/pesanan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // Mendapatkan URL sebelumnya (referer)
        $referer = $request->headers->get('referer');

        // Cek apakah URL sebelumnya mengandung '/pekerjaan'
        $tampilUbah = false;
        if ($referer && strpos($referer, '/pekerjaan') !== false) {
            $tampilUbah = true;
        }

        return view('pesanan.detail', [
            'data' => Pesanan::where('id_pesanan', $id)->get(),
            'detail' => DB::table('pesanan_detail')
                ->join('barang', 'pesanan_detail.id_barang', '=', 'barang.id_barang')
                ->join('finishing', 'pesanan_detail.id_finishing', '=', 'finishing.id_finishing')
                ->where('id_pesanan', $id)
                ->get()
        ]);
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
        PesananDetail::where('id_pesanan', $id)->delete();
        Pesanan::where('id_pesanan', $id)->delete();

        return back();
    }
}
