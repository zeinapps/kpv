<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Iuran;
use App\Iuranbayar;
use App\Iuranjenis;
use App\Iurankomponen;
use DB;
use App\User;
use Master;

class IuranbayarController extends Controller {

    public function index(Request $request) {
        $rt = $request->user()->rt;
        $limit = $request->limit ? $request->limit : 10;
        $bulan = $request->bulan ? $request->bulan : date('n');
        $tahun = $request->tahun ? $request->tahun : date('Y');
        $is_bayar = $request->is_bayar ? $request->is_bayar : 1;
        
        $cek_exists = Iuran::where('bulan',$bulan)
                ->where('rt_id',$rt)
                ->where('tahun',$tahun)->first();
        
        if(!$cek_exists){
            $data = [
                'data' => [],
                'pagination' => null,
                'no' => null,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'is_bayar' => $is_bayar,
                'komponen_jumlah' => 0,
            ];
             return view('sbadmin2.iuranbayar.index', $data)
                    ->withErrors(['Bulan '.Master::$BULAN[$bulan].' '.$tahun.' belum dibuat ']);
        }
        
        $iuran_bayar = Iuranbayar::where('iuran_id',$cek_exists->id)->get();
        $users_bayar = [];
        $users = [];
        foreach ($iuran_bayar as $value) {
            $users_bayar[$value->user_id] = $value->jumlah;
                    $users[] = $value->user_id;
        }
        
        $query = new User;
        if($is_bayar == 2){
            $query = $query->whereIn('users.id', $users);
        }else if($is_bayar == 3){
            $query = $query->whereNotIn('users.id', $users);
        }
            
        $query = $query->select('users.id as id','users.nama as nama');
        $query = $query->where('rt',$rt);
        $query = $query->where('keluarga_dari',0);
        $query = $query->paginate($limit);
        $Items = array();
        foreach ($query->items() as $value) {
            $value->jumlah = key_exists($value->id, $users_bayar)? $users_bayar[$value->id] : 0;
            $Items[] = $value;
        }
        
        $iuran_komponen = Iurankomponen::join('iuran', 'iuran_komponen.iuran_id', '=', 'iuran.id')
                  ->where('iuran.bulan',$bulan)
                  ->where('iuran.tahun',$tahun)
                  ->select(DB::raw('SUM(jumlah) as jumlah'))
                 ->first();
        
        $ada_yang_bayar = 0;
        if($iuran_bayar){
            $ada_yang_bayar = 1;
        }
        
        $page = $request->page ? $request->page : 1;
        $no = ($page-1) * $limit + 1;
        
        $data = [
            'data' => $Items,
            'pagination' => $query,
            'no' => $no,
            'bulan' => $bulan,
            'Bulan' => Master::$BULAN[$bulan],
            'tahun' => $tahun,
            'iuran_id' => $cek_exists->id,
            'is_bayar' => $is_bayar,
            'ada_yang_bayar' => $ada_yang_bayar,
            'komponen_jumlah' => isset($iuran_komponen->jumlah)?$iuran_komponen->jumlah:0,
        ];
        
        
        
        return view('sbadmin2.iuranbayar.index', $data);
        
    }
    
    public function delete(Request $request, $userid,$iuranid) {
        $cek_exists = Iuran::find($iuranid);
        
        $redirect_error = url()->previous();
        if($request->user()->rt != $cek_exists->rt_id){
                return redirect($redirect_error)
                    ->withErrors(["Anda tidak berhak menghapus data ini"])
                    ->withInput();
            }
        
        if(!$cek_exists){
            return redirect('bayar_iuran');
        }
        $query = Iuranbayar::where('iuran_id',$iuranid)
                ->where('user_id',$userid);
        $query->delete();
        return redirect("bayar_iuran?bulan=$cek_exists->bulan&tahun=$cek_exists->tahun");
    }
    
    public function store(Request $request,$userid,$iuranid) {
    
        $cek_exists = Iuran::find($iuranid);
        $redirect_error = url()->previous();
        if($request->user()->rt != $cek_exists->rt_id){
                return redirect($redirect_error)
                    ->withErrors(["Anda tidak berhak mengubah data ini"])
                    ->withInput();
            }
            
        if(!$cek_exists){
            return redirect('bayar_iuran');
        }
        $iuran_komponen = Iurankomponen::where('iuran_id',$iuranid)
              ->select(DB::raw('SUM(jumlah) as jumlah'))
             ->first();
        try {      
            $query = new Iuranbayar;
            $query->iuran_id = $iuranid;
            $query->user_id = $userid;
            $query->jumlah = $iuran_komponen->jumlah;
            $query->save();
            
        } catch (\Exception $exc) {
            return  redirect('bayar_iuran');
            
       
        }
        return redirect("bayar_iuran?bulan=$cek_exists->bulan&tahun=$cek_exists->tahun");
    }
    
   
}
