<?php

namespace App\Models;

use App\Models\PesananDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    protected $guarded = [];

    public function pesanan_detail()
    {
        return $this->belongsTo(PesananDetail::class, 'id_pesanan_detail');
    }
}
