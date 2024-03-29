<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Status;
use App\Models\Pesanan;
use App\Models\Finishing;
use Illuminate\Http\Request;
use App\Models\PesananDetail;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class PesananDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pesanan_detail.index', [
            'data' => Pesanan::find(session('id_pesanan')),
            'barang' => Barang::all(),
            'finishing' => Finishing::all(),
            // 'status' => Status::all()->pluck('status', 'id_status'),
            'detail' => DB::table('pesanan_detail')
                ->join('barang', 'pesanan_detail.id_barang', '=', 'barang.id_barang')
                ->where('id_pesanan', '=', session('id_pesanan'))
                ->get(),
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
        // Define validation rules
        $rules = [
            'nama_pesanan' => 'required|string',
            'id_barang' => 'required',
            'jumlah' => 'required|numeric',
        ];

        // Run the validation
        $request->validate($rules);
        PesananDetail::create([
            'id_pesanan' => $request->id_pesanan,
            'nama_pesanan' => $request->nama_pesanan,
            'id_barang' => $request->id_barang,
            'id_bahan' => $request->id_bahan,
            'harga' => $request->harga,
            'satuan' => $request->satuan,
            'panjang' => $request->panjang,
            'lebar' => $request->lebar,
            'totalukuran' => $request->totalukuran,
            'totalharga' => $request->totalharga,
            'jumlah' => $request->jumlah,
            'subtotal' => $request->subtotal,
            'id_finishing' => $request->id_finishing,
            'status_detail' => $request->status_detail,
            'desainer' => $request->desainer,
            'biaya_desain' => $request->biaya_desain
        ]);

        return back()->with('sukses-input-pesanan', 'Pesanan Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = PesananDetail::find($id);

        return response()->json($detail);
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
        PesananDetail::find($id)->update([
            'nama_pesanan' => $request->nama_pesanan,
            'id_barang' => $request->id_barang,
            'id_bahan' => $request->id_bahan,
            'harga' => $request->harga,
            'satuan' => $request->satuan,
            'panjang' => $request->panjang,
            'lebar' => $request->lebar,
            'totalukuran' => $request->totalukuran,
            'totalharga' => $request->totalharga,
            'jumlah' => $request->jumlah,
            'subtotal' => $request->subtotal,
            'id_finishing' => $request->id_finishing,
            'status_detail' => $request->status_detail,
            'biaya_desain' => $request->biaya_desain
        ]);

        return back()->with('sukses-edit-pesanan', 'Pesanan Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PesananDetail::find($id)->delete();

        return back();
    }

    public function batalPesanan($id)
    {
        PesananDetail::where('id_pesanan', $id)->delete();
        Pesanan::where('id_pesanan', $id)->delete();
        return redirect('/pesanan');
    }

    public function loadBarang(Request $request)
    {
        $data = Barang::where('id_barang', $request->id_barang)->first();

        return response()->json($data);
    }
}
