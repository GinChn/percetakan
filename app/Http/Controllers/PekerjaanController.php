<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PesananDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $progresPesanan = $this->getProgresPesanan();

        return view('pekerjaan.index', compact('progresPesanan'));
    }

    public function pekerjaanDetail($id)
    {
        return view('pekerjaan.detail_status', [
            'data' => Pesanan::where('id_pesanan', $id)->get(),
            'detail' => DB::table('pesanan_detail')
                ->join('barang', 'pesanan_detail.id_barang', '=', 'barang.id_barang')
                ->join('finishing', 'pesanan_detail.id_finishing', '=', 'finishing.id_finishing')
                ->where('id_pesanan', $id)
                ->get()
        ]);

        // return view('pekerjaan.detail_status');
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $statusDetail = $request->input('status_detail');
            $statusText = $this->getStatusValue($statusDetail); // Call getStatusValue function

            // Check if the record exists, and if not found, it will throw an exception
            $pesananDetail = PesananDetail::findOrFail($id);

            // Use the 'update' method to update the 'status_detail' attribute
            $pesananDetail->update(['status_detail' => $statusText]);

            return back()->with('status', 'Status updated successfully');
        } catch (ModelNotFoundException $exception) {
            // Handle the case when the record with the specified $id is not found
            return back()->withErrors('Record not found.');
        }
    }

    public function belumAdaDesain()
    {
        // $data = Pesanan::with('pesanan_detail.finishing')->get();

        $data = PesananDetail::select('*')
            ->join('pesanan', 'pesanan_detail.id_pesanan', '=', 'pesanan.id_pesanan')
            ->join('finishing', 'pesanan_detail.id_finishing', '=', 'finishing.id_finishing')
            ->join('barang', 'pesanan_detail.id_barang', '=', 'barang.id_barang')
            ->where('status_detail', 'Belum Ada Desain')
            ->get();
        return view('pekerjaan.belum_ada_desain', ['data' => $data]);
    }

    public function sudahAdaDesain()
    {
        $data = PesananDetail::select('*')
            ->join('pesanan', 'pesanan_detail.id_pesanan', '=', 'pesanan.id_pesanan')
            ->join('finishing', 'pesanan_detail.id_finishing', '=', 'finishing.id_finishing')
            ->join('barang', 'pesanan_detail.id_barang', '=', 'barang.id_barang')
            ->where('status_detail', 'Sudah Ada Desain')
            ->get();
        return view('pekerjaan.sudah_ada_desain', ['data' => $data]);
    }


    protected function getStatusValue($statusDetail)
    {
        switch ($statusDetail) {
            case "1":
                return "Belum Ada Desain";
            case "2":
                return "Sudah Ada Desain";
            case "3":
                return "Dikerjakan";
            case "4":
                return "Selesai";
            default:
                return "Unknown Status";
        }
    }


    private function getProgresPesanan()
    {
        $progresPesanan = Pesanan::leftJoin('pesanan_detail', 'pesanan.id_pesanan', '=', 'pesanan_detail.id_pesanan')
            ->select(
                'pesanan.id_pesanan',
                'pesanan.no_nota',
                'pesanan.nama_pelanggan',
                'pesanan.created_at',
                DB::raw('COUNT(pesanan_detail.id_pesanan) as banyak_status_detail'),
                DB::raw('SUM(CASE WHEN pesanan_detail.status_detail = "Selesai" THEN 1 ELSE 0 END) as banyak_status_selesai')
            )
            ->groupBy('pesanan.id_pesanan', 'pesanan.no_nota', 'pesanan.nama_pelanggan', 'pesanan.created_at')
            ->get();

        $progresPesanan->transform(function ($item) {
            $item->progres = ($item->banyak_status_detail == 0) ? 0 : ($item->banyak_status_selesai / $item->banyak_status_detail) * 100;
            return $item;
        });

        return $progresPesanan;
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
