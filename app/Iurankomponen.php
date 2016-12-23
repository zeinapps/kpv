<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iurankomponen extends Model
{
    protected $table = 'iuran_komponen';
    public $timestamps = false;
    protected $fillable = ['id','iuran_id','nama_iuran','jumlah'];
}
