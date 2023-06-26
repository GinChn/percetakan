<?php

namespace App\Models;

use App\Models\Bahan;
use App\Models\Barang;
use App\Models\Pesanan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PesananDetail extends Model
{
    use HasFactory;

    protected $table = 'pesanan_detail';
    protected $primaryKey = 'id_pesanan_detail';
    protected $guarded = [];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'id_bahan');
    }

    // public static function simpan_pesanan($req)
    // {
    //     Pesanan::find(session('id_pesaanan'))->update([
    //         'nama_pelanggan' => $req->nama_pelanggan,
    //         'no_telp' => $req->no_telp,
    //         'total' => $req->total,
    //         'status_desain' => $req->status_desain,
    //         'status_pesanan' => $req->status_pesanan,
    //     ]);

    //     Pelanggan::create([
    //         'nama_pelanggan' => $req->nama_pelanggan,
    //         'no_telp' => $req->no_telp,
    //         'paassword' => 123
    //     ]);
    // }
}
