<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Urunan;
use App\Urunanbayar;
use DB;
use Master;

class UrunanController extends Controller {

    public function index(Request $request) {
        $limit = $request->limit ? $request->limit : 10;
        $query = Urunan::where('rt_id',$request->user()->rt);
        $query = $this->order($query, 'id', 'DESC');
        $query = $query->paginate($limit);
        $page = $request->page ? $request->page : 1;
        $no = ($page-1) * $limit + 1;
        $Data = $query->toArray();
        $data = [
            'data' => $Data['data'],
            'pagination' => $query,
            'no' => $no
        ];
        return view('sbadmin2.urunan.index', $data);
        
    }
    
    
    public function create(Request $request) {
        $urunan = [
            'is_wajib' => 0,
            'is_per_kk' => 1,
        ];
        
        return view('sbadmin2.urunan.form',$urunan);
    }
    
    public function edit(Request $request, $id) {
        $urunan = Urunan::find($id);
        return view('sbadmin2.urunan.form',$urunan);
    }
    
    public function delete(Request $request, $id) {
        $redirect_error = url()->previous();
        try {
            $urunan = Urunan::find($id);
            
            if($request->user()->rt != $urunan->rt_id){
                return redirect($redirect_error)
                    ->withErrors(["Anda tidak berhak menghapus data ini"])
                    ->withInput();
            }
            
            if(Urunanbayar::where('urunan_id',$id)->first()){
                return redirect('urunan')
                    ->withErrors(["Maaf, Urunan $urunan->judul tidak bisa di hapus karena sudah ada yang membayar"])
                    ->withInput();
            }
            $urunan->delete();
        } catch (\Exception $exc) {
            return redirect('urunan')
                    ->withErrors([$exc->getMessage()])
                    ->withInput();
            
       
        }
        
        return redirect('urunan');
    }
    
    public function store(Request $request) {
    
        $query = null;
        $add = true;
        $redirect_error = url()->previous();
        if($request->id){
            $query = Urunan::find($request->id);
            
            if($request->user()->rt != $query->rt_id){
                return redirect($redirect_error)
                    ->withErrors(["Anda tidak berhak mengubah data ini"])
                    ->withInput();
            }
            
            $urunan_bayar = Urunanbayar::where('urunan_id',$request->id)->first();
            $add = false;
            if($urunan_bayar){
                return redirect($redirect_error)
                    ->withErrors([" tidak bisa di ubah karena sudah ada yang bayar"])
                    ->withInput();
            }
        }else{
            $urunan = Urunan::where('rt_id',$request->user()->rt)
                    ->where('judul',$request->judul)->first();
            if($urunan){
                return redirect($redirect_error)
                    ->withErrors(["Judul tidak boleh sama. '$request->judul' sudah pernah di pakai"])
                    ->withInput();
            }
            $query = new Urunan($request->all());
        }
        
        try {  
            if ($add) {
                $query->rt_id = $request->user()->rt;
                $query->save();
            } else {
                $query->update($request->all());
            }
        } catch (\Exception $exc) {
            return redirect($redirect_error)
                    ->withErrors([$exc->getMessage()])
                    ->withInput();
            
       
        }
        
        return redirect('urunan');
    }
    
    public function apiurunan(Request $request) {
        
        $data = Urunan::where('rt_id', $request->user()->rt )
                ->select('id','judul')
                ->where('judul', 'like', "%$request->judul%")
                ->get();
        return  response()->json($data);
    }
   
}
