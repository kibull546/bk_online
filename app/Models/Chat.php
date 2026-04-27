<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'user_id',
        'guru_id',
        'message',
        'sender',
        'deleted_by_siswa',
        'deleted_by_guru'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}