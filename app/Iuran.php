<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Base;

class Iuran extends Model
{
    use Base;
    protected $table = 'iuran';
    protected $fillable = ['id','bulan','tahun','rt_id'];
    public $timestamps = false;
    
    public function komponen()
    {
        return $this->hasMany('App\Iurankomponen');
    }
}
