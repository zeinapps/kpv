<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Urunan extends Model
{
    protected $table = 'urunan';
    protected $fillable = ['id','judul','is_wajib','keterangan','jumlah','is_per_kk','rt_id'];
    public $timestamps = false;
}
