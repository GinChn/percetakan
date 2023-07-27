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
        // $startDate = Carbon::now()->subDays(6);
        // where('created_at', '>=', $startDate)
        $errorMessage = null;
        $pesanan = Pesanan::where('status_pesanan', '<>', 'Sudah Diambil')
            ->orderBy('status_pesanan', 'desc')
            ->orderBy('created_at', 'asc')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('cek_pesanan.index', ['pesanan' => $pesanan]);
    }

    public function show($no_nota)
    {
        try {
            $data = Pesanan::where('no_nota', $no_nota)->firstOrFail();

            $detail = DB::table('pesanan_detail')
                ->join('barang', 'pesanan_detail.id_barang', '=', 'barang.id_barang')
                ->join('finishing', 'pesanan_detail.id_finishing', '=', 'finishing.id_finishing')
                ->where('id_pesanan', $data->id_pesanan)
                ->get();

            return view('cek_pesanan.detail', [
                'data' => collect([$data]),
                'detail' => $detail
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            $errorMessage = 'Pesanan tidak ditemukan';
            $pesanan = Pesanan::where('status_pesanan', '<>', 'Sudah Diambil')
                ->orderBy('status_pesanan', 'desc')
                ->orderBy('created_at', 'asc')
                ->orderBy('updated_at', 'desc')
                ->get();

            return view('cek_pesanan.index', [
                'errorMessage' => $errorMessage,
                'pesanan' => $pesanan
            ]);
        }
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
