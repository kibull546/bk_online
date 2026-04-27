<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'student_code',
    ];

    /**
     * Hidden fields
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast attributes
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Helper: cek role guru
     */
    public function isGuru()
    {
        return $this->role === 'guru';
    }

    /**
     * Helper: cek role admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Helper: cek role siswa
     */
    public function isSiswa()
    {
        return $this->role === 'siswa';
    }
}