<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finishing extends Model
{
    use HasFactory;

    protected $table = 'finishing';
    protected $primaryKey = 'id_finishing';
    protected $guarded = [];
}
