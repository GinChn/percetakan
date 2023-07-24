<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $startDate = Carbon::now()->subDays(6);

        $pesanan = Pesanan::where('created_at', '>=', $startDate)
            ->where('status_pesanan', '<>', 'Sudah Diambil')
            ->orderBy('status_pesanan', 'desc')
            ->orderBy('created_at', 'asc')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('cek_pesanan.index', ['pesanan' => $pesanan]);
    }

    public function cekStatusDetail($id)
    {

        return view('cek_pesanan.detail', [
            'data' => Pesanan::where('id_pesanan', $id)->get(),
            'detail' => DB::table('pesanan_detail')
                ->join('barang', 'pesanan_detail.id_barang', '=', 'barang.id_barang')
                ->join('finishing', 'pesanan_detail.id_finishing', '=', 'finishing.id_finishing')
                ->where('id_pesanan', $id)
                ->get()
        ]);
        // $data = Pesanan::where('id_pesanan', $id)->get();
        // $detail = DB::table('pesanan_detail')
        //     ->join('barang', 'pesanan_detail.id_barang', '=', 'barang.id_barang')
        //     ->join('finishing', 'pesanan_detail.id_finishing', '=', 'finishing.id_finishing')
        //     ->where('id_pesanan', $id)
        //     ->get();

        // dd($data, $detail);
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