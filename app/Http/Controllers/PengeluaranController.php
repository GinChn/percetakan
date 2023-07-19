<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pengeluaran.index', [
            'pengeluaran' => Pengeluaran::orderBy('created_at', 'desc')->get()
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
        Pengeluaran::create([
            'keterangan' => $request->keterangan,
            'nominal' => $request->nominal,
            'jumlah' => $request->jumlah,
            'total' => $request->total
        ]);

        return redirect('/pengeluaran')->with('sukses-tambah-pengeluaran', 'Pengeluaran Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pengeluaran = Pengeluaran::find($id);

        return response()->json($pengeluaran);
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
        Pengeluaran::find($id)->update([
            'keterangan' => $request->keterangan,
            'nominal' => $request->nominal,
            'jumlah' => $request->jumlah,
            'total' => $request->total
        ]);

        return redirect('/pengeluaran')->with('sukses-ubah-pengeluaran', 'Pengeluaran Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *S
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pengeluaran::find($id)->delete();

        return back();
    }
}
