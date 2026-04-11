<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curhat extends Model
{
    protected $fillable = [
    'pesan',
    'kategori',
    'kode_unik',
    'status'
];
}
