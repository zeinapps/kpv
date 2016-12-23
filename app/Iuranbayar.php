<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iuranbayar extends Model
{
    protected $table = 'iuran_bayar';
    public $timestamps = false;
    protected $fillable = ['id','user_id','iuran_id','jumlah'];
}
