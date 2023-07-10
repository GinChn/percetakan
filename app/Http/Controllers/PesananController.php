<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
            'pesanan' => Pesanan::all()
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
        Pesanan::FindorFail($request->id_pesanan)->update([
            'nama_pelanggan' => $request->nama_pelanggan,
            'no_telp' => $request->no_telp,
            'total' => $request->total,
            'status_pembayaran' => 'Belum Lunas'
        ]);

        return redirect('/pesanan');
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
        Pesanan::find($id)->delete();

        return back();
    }
}
