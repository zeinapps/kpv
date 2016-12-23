<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Urunanbayar extends Model
{
    protected $table = 'urunan_bayar';
    protected $fillable = ['id','urunan_id','user_id','jumlah'];
    public $timestamps = false;
}
