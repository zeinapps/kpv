<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Iuran;
use App\Iuranbayar;
use App\Iuranjenis;
use App\Iurankomponen;
use Validator;
use Master;

class IuranjenisController extends Controller {

    public function index(Request $request) {
        $limit = $request->limit ? $request->limit : 10;
        $query = new Iuranjenis;
        $query = $query->where('rt_id',$request->user()->rt);
        $query = $this->order($query, 'id', 'ASC');
        $query = $query->paginate($limit);
        $page = $request->page ? $request->page : 1;
        $no = ($page-1) * $limit + 1;
        $Data = $query->toArray();
        $data = [
            'data' => $Data['data'],
            'pagination' => $query,
            'no' => $no,
        ];
        return view('sbadmin2.jenisiuran.index', $data);
        
    }
    
    
    public function create() {
        return view('sbadmin2.jenisiuran.form');
    }
    
    public function edit($id) {
        $query = Iuranjenis::find($id);
        return view('sbadmin2.jenisiuran.form',$query);
    }
    
    public function delete(Request $request, $id) {
        $redirect_error = url()->previous();
        try {
            $query = Iuranjenis::find($id);
            
            if($request->user()->rt != $query->rt_id){
                return redirect($redirect_error)
                    ->withErrors(["Anda tidak berhak menghapus data ini"])
                    ->withInput();
            }
            
            $query->delete();
        } catch (\Exception $exc) {
            return redirect('jenis_iuran')
                    ->withErrors([$exc->getMessage()])
                    ->withInput();
            
        }
        
        return redirect('jenis_iuran');
    }
    
    public function store(Request $request) {
        $query = null;
        $add = true;
        $redirect_error = url()->previous();
        if($request->id){
            $query = Iuranjenis::find($request->id);
            if($request->user()->rt != $query->rt_id){
                return redirect($redirect_error)
                    ->withErrors(["Anda tidak berhak mengubah data ini"])
                    ->withInput();
            }
            $add = false;
        }else{
            $query = new Iuranjenis($request->all());
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
        return redirect('jenis_iuran');
    }
    
   
}
