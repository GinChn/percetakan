<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Satuan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrator.produk.index', [
            'produk' => Produk::all(),
            'kategori' => Kategori::all(),
            'satuan' => Satuan::all()
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
        Produk::create([
            'nama_produk' => $request->nama_produk,
            'jenis_bahan' => $request->jenis_bahan,
            'id_kategori_mesin' => $request->jenis_mesin,
            'id_satuan' => $request->nama_satuan,
            'harga' => $request->harga
        ]);

        return redirect('/produk')->with('sukses-tambah', 'Data Berhasil Ditambahkan');
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
        $produk = Produk::find($id);
        return view('administrator.produk.edit', [
            'produk' => $produk,
            'kategori' => Kategori::all(),
            'satuan' => Satuan::all()
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
        Produk::find($id)->update([
            'nama_produk' => $request->nama_produk,
            'jenis_bahan' => $request->jenis_bahan,
            'id_kategori_mesin' => $request->jenis_mesin,
            'id_satuan' => $request->nama_satuan,
            'harga' => $request->harga
        ]);

        return redirect('/produk')->with('sukses-ubah', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Produk::find($id)->delete();

        return back();
    }
}
