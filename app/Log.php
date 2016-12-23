<?php

namespace App;

use App\Base;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use Base;
    protected $table = 'log';
    protected $fillable = ['id','user_id','action','waktu'];
}
