<?php

namespace App\Http\Controllers;

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
        $tanggal_laporan = $request->input('tanggal_laporan');
        // Lakukan operasi lainnya dengan nilai tanggal...
        $data_pemasukan = Pesanan::whereDate('tanggal', $tanggal_laporan)
            ->where('status_pesanan', 'Selesai')
            ->get();
        $data_pengeluaran = Pengeluaran::whereDate('created_at', $tanggal_laporan)->get();

        $data_laporan = [
            'data_masuk' => $data_pemasukan,
            'data_keluar' => $data_pengeluaran
        ];

        return view('laporan.index', $data_laporan);
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
