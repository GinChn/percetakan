<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
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
        $disetujui = Pengeluaran::where('status_pengeluaran', 'Disetujui')
            ->orderBy('created_at', 'desc')->get();

        $ditolak = Pengeluaran::where('status_pengeluaran', 'Ditolak')
            ->orderBy('created_at', 'desc')->get();

        $pending = Pengeluaran::where('status_pengeluaran', NULL)
            ->orderBy('created_at', 'desc')->get();

        $dataPengeluaran = [
            'disetujui' => $disetujui,
            'ditolak' => $ditolak,
            'pending' => $pending,
        ];

        return view('pengeluaran.index', $dataPengeluaran);
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

    public function disetujui($id)
    {
        // Cari data pengeluaran berdasarkan ID
        $pengeluaran = Pengeluaran::find($id);

        if (!$pengeluaran) {
            return response()->json(['message' => 'Data pengeluaran tidak ditemukan'], 404);
        }
        $manajer = auth()->user()->nama;

        $pengeluaran->update([
            'status_pengeluaran' => 'Disetujui',
            'manajer' => $manajer,
        ]);

        return redirect('/pengeluaran')->with('sukses-disetujui', 'Pengeluaran Berhasil Disetujui');
    }

    public function ditolak($id)
    {
        // Cari data pengeluaran berdasarkan ID
        $pengeluaran = Pengeluaran::find($id);

        if (!$pengeluaran) {
            return response()->json(['message' => 'Data pengeluaran tidak ditemukan'], 404);
        }

        // Update status_pengeluaran menjadi "Ditolak"
        $manajer = auth()->user()->nama;

        $pengeluaran->update([
            'status_pengeluaran' => 'Ditolak',
            'manajer' => $manajer,
        ]);

        return redirect('/pengeluaran')->with('sukses-ditolak', 'Pengeluaran Berhasil Ditolak');
    }

    public function exportPengeluaran($id)
    {
        $data = Pengeluaran::find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Data not found.');
        }

        $tanggal = date('dmY', strtotime($data->created_at));
        $keterangan = str_replace(" ", "-", $data->keterangan);
        $namaDokumen = "pengeluaran_{$tanggal}_{$keterangan}.pdf";

        $pdf = PDF::loadView('pengeluaran.export-pengeluaran', compact('data'));

        return $pdf->download($namaDokumen);
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
