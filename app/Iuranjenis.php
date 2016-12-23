<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iuranjenis extends Model
{
    protected $table = 'iuran_jenis';
    public $timestamps = false;
    protected $fillable = ['id','nama_iuran','jumlah','keterangan','rt_id'];
}
