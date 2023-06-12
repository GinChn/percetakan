<?php

namespace App\Models;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mesin extends Model
{
    use HasFactory;

    protected $table = 'mesin';
    protected $primaryKey = 'id_mesin';
    protected $guarded = [];
}
