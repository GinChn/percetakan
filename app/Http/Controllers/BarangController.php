<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Mesin;
use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('barang.index', [
            'barang' => Barang::orderBy('nama_barang', 'asc')->get(),
            'bahan' => Bahan::all()->pluck('nama_bahan', 'id_bahan'),
            'mesin' => Mesin::all()->pluck('jenis_mesin', 'id_mesin'),
            'satuan' => Satuan::all()->pluck('nama_satuan', 'id_satuan')
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
        Barang::create([
            'nama_barang' => $request->nama_barang,
            'id_bahan' => $request->id_bahan,
            'id_mesin' => $request->id_mesin,
            'satuan' => $request->satuan,
            'harga' => $request->harga
        ]);

        return redirect('/barang')->with('sukses-tambah-barang', 'Data Barang Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $barang = Barang::find($id);

        return response()->json($barang);
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
        Barang::find($id)->update([
            'nama_barang' => $request->nama_barang,
            'id_bahan' => $request->id_bahan,
            'id_mesin' => $request->id_mesin,
            'satuan' => $request->satuan,
            'harga' => $request->harga
        ]);

        return redirect('/barang')->with('sukses-ubah-barang', 'Data Barang Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Barang::find($id)->delete();

        return back();
    }
}
