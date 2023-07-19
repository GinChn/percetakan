<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pembayaran.index', [
            'pembayaran' => Pesanan::orderBy('no_nota', 'desc')->get()
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
        Pesanan::find($request->id_pesanan)->update([
            'bayar' => $request->bayar,
            'kembali' => $request->kembali,
            'status_pembayaran' => 'Lunas'
        ]);

        return redirect('/pembayaran');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('pembayaran.detail', [
            'data' => Pesanan::where('id_pesanan', $id)->get(),
            'detail' => DB::table('pesanan_detail')
                        ->join('barang', 'pesanan_detail.id_barang', '=', 'barang.id_barang')
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
        return view('pembayaran.edit', [
            'data' => Pesanan::where('id_pesanan', $id)->get(),
            'detail' => DB::table('pesanan_detail')
                        ->join('barang', 'pesanan_detail.id_barang', '=', 'barang.id_barang')
                        ->where('id_pesanan', $id)
                        ->get()
        ]);
    }

    public function pembayaran($id)
    {
        return view('pembayaran.bayar', [
            'data' => Pesanan::where('id_pesanan', $id)->get(),
            'detail' => DB::table('pesanan_detail')
                        ->join('barang', 'pesanan_detail.id_barang', '=', 'barang.id_barang')
                        ->where('id_pesanan', $id)
                        ->get()
        ]);
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

    public function nota($id)
    {
        return view('pembayaran.nota', [
            'data' => Pesanan::where('id_pesanan', $id)->get(),
            'detail' => DB::table('pesanan_detail')
                        ->join('barang', 'pesanan_detail.id_barang', '=', 'barang.id_barang')
                        ->where('id_pesanan', $id)
                        ->get()
        ]);
    }
}
