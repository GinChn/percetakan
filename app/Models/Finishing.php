<?php

namespace App\Models;

use App\Models\PesananDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Finishing extends Model
{
    use HasFactory;

    protected $table = 'finishing';
    protected $primaryKey = 'id_finishing';
    protected $guarded = [];

    public function pesanan_detail()
    {
        return $this->hasMany(PesananDetail::class, 'id_pesanan');
    }
}
