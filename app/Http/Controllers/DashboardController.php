<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function index()
    {
       
        $data = [
            'laporan_baru' => 10,
            'laporan_dalam_proses' => 10,
        ];
        return view('sbadmin2.index', $data);
    }
}
