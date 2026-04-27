<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curhat extends Model
{
   protected $fillable = [
    'nama',
    'pesan',
    'balasan',
    'kategori',
    'status'
];
}
