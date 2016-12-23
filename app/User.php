<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Kodeine\Acl\Traits\HasRole;
use App\Base;

class User extends Authenticatable
{
    use HasRole, Base;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'username', 'email', 'password', 'blok', 'tempat_lahir',
        'tanggal_lahir', 'ktp', 'gambar_profil', 'keluarga_dari', 'is_menetap',
        'hp', 'remember_token', 'deposito', 'status_keluarga', 'created_at',
        'updated_at', 'agama', 'rt'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
