<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Urunan;
use App\Urunanbayar;
use DB;
use App\User;
use Master;

class UrunanbayarController extends Controller {

    public function index(Request $request) {
        $rt = $request->user()->rt;
        $limit = $request->limit ? $request->limit : 10;
        $is_bayar = $request->is_bayar ? $request->is_bayar : 1;
        
        $urunan = Urunan::where('rt_id',$rt);
        if($request->judul){
            $urunan = $urunan->where('judul',$request->judul);
        }
        $urunan = $this->order($urunan, 'id', 'DESC')->first();
        if(!$urunan){
            $data = [
                'data' => [],
                'pagination' => null,
                'no' => null,
                'is_bayar' => $is_bayar,
            ];
             return view('sbadmin2.urunanbayar.index', $data)
                    ->withErrors(['Belum ada data yang dibuat ']);
        }
        
        $urunan_bayar = Urunanbayar::where('urunan_id',$urunan->id)->get();
        $users_bayar = [];
        $users = [];
        foreach ($urunan_bayar as $value) {
            $users_bayar[$value->user_id] = $value->jumlah;
                    $users[] = $value->user_id;
        }
//        $is_bayar = 1 ==> semua user
        $query = new User;
        if($is_bayar == 2){ // sudah bayar
            $query = $query->whereIn('users.id', $users);
        }else if($is_bayar == 3){ // belum bayar
            $query = $query->whereNotIn('users.id', $users);
        }
            
        $query = $query->select('users.id as id','users.nama as nama');
        $query = $query->where('rt',$rt);
        if($urunan->is_per_kk){
            $query = $query->where('keluarga_dari',0);
        }
        $query = $query->paginate($limit);
        $Items = array();
        foreach ($query->items() as $value) {
            $value->jumlah = key_exists($value->id, $users_bayar)? $users_bayar[$value->id] : 0;
            $Items[] = $value;
        }
        
        $ada_yang_bayar = 0;
        if($urunan_bayar){
            $ada_yang_bayar = 1;
        }
        
        $page = $request->page ? $request->page : 1;
        $no = ($page-1) * $limit + 1;
        
        $Juduls = Urunan::where('rt_id', $request->user()->rt )
                ->select('judul')
                ->get();
        $juduls = [];
        foreach ($Juduls as $jud) {
            $juduls[] = $jud->judul;
        }
        $juduls = json_encode($juduls);
        
        $data = [
            'data' => $Items,
            'pagination' => $query,
            'no' => $no,
            'urunan_id' => $urunan->id,
            'is_bayar' => $is_bayar,
            'ada_yang_bayar' => $ada_yang_bayar,
            'judul' => $urunan->judul,
            'juduls' => $juduls,
            'keterangan' => $urunan->keterangan,
            'jumlah' => isset($urunan->jumlah)?$urunan->jumlah:0,
        ];
        
        
        
        return view('sbadmin2.urunanbayar.index', $data);
        
    }
    
    public function delete(Request $request, $userid,$urunanid) {
        $urunan = Urunan::find($urunanid);
        $redirect_error = url()->previous();
        if($request->user()->rt != $urunan->rt_id){
                return redirect($redirect_error)
                    ->withErrors(["Anda tidak berhak menghapus data ini"])
                    ->withInput();
            }
        
        if(!$urunan){
            return redirect('bayar_urunan');
        }
        $query = Urunanbayar::where('urunan_id',$urunanid)
                ->where('user_id',$userid);
        $query->delete();
        return redirect("urunan_bayar?judul=$urunan->judul");
    }
    
    public function store(Request $request,$userid,$urunanid) {
    
        $urunan = Urunan::find($urunanid);
        $redirect_error = url()->previous();
        if($request->user()->rt != $urunan->rt_id){
                return redirect($redirect_error)
                    ->withErrors(["Anda tidak berhak mengubah data ini"])
                    ->withInput();
            }
            
        if(!$urunan){
            return redirect('bayar_urunan');
        }
       
        try {      
            $query = new Urunanbayar;
            $query->urunan_id = $urunanid;
            $query->user_id = $userid;
            $query->jumlah = $urunan->jumlah;
            $query->save();
            
        } catch (\Exception $exc) {
            return  redirect('bayar_urunan');
            
       
        }
        return redirect("urunan_bayar?judul=$urunan->judul");
    }
    
   
}
