<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Iuran;
use App\Iuranbayar;
use App\Iuranjenis;
use App\Iurankomponen;
use DB;
use Master;

class IuranController extends Controller {

    public function index(Request $request) {
        $limit = $request->limit ? $request->limit : 10;
        $query = Iuran::with(['komponen' => function($q){}]);
        $query = $query->where('rt_id',$request->user()->rt);
        $query = $this->order($query, 'bulan', 'DESC');
        $query = $this->order($query, 'tahun', 'DESC');
        $query = $query->paginate($limit);
        $page = $request->page ? $request->page : 1;
        $no = ($page-1) * $limit + 1;
        $Data = $query->toArray();
        $data = [
            'data' => $Data['data'],
            'pagination' => $query,
            'no' => $no,
            'Bulan' =>Master::$BULAN
        ];
        return view('sbadmin2.iuran.index', $data);
        
    }
    
    
    public function create(Request $request) {
        
        $komponen = Iuranjenis::where('rt_id',$request->user()->rt)
                ->get();
       
        if(!$komponen->toArray()){
            return redirect('iuran')
                    ->withErrors(['Jenis Iuran belum dibuat'])
                    ->withInput();
        }
        $tahun = date('Y');
        return view('sbadmin2.iuran.form',['komponen'=>$komponen,'tahun'=>$tahun]);
    }
    
    public function edit(Request $request, $id) {
        $komponen = Iuranjenis::where('rt_id',$request->user()->rt)
                ->get();
        $iuran = Iuran::find($id);
        $tahun = $iuran->tahun;
        $bulan = $iuran->bulan;
        return view('sbadmin2.iuran.form',['id'=>$iuran->id,'komponen'=>$komponen,'tahun'=>$tahun,'bulan'=>$bulan]);
    }
    
    public function delete(Request $request,$id) {
        $redirect_error = url()->previous();
        try {
            $iuran = Iuran::find($id);
            
            if($request->user()->rt != $iuran->rt_id){
                return redirect($redirect_error)
                    ->withErrors(["Anda tidak berhak menghapus data ini"])
                    ->withInput();
            }
            
            if(Iuranbayar::where('iuran_id',$id)->first()){
                return redirect('iuran')
                    ->withErrors(["Maaf, Iuran bulan " . Master::$BULAN[$iuran->bulan]. " $iuran->tahun tidak bisa di hapus karena sudah ada yang membayar"])
                    ->withInput();
            }
            Iurankomponen::where('iuran_id',$id)->delete();
            $iuran->delete();
        } catch (\Exception $exc) {
            return redirect('iuran')
                    ->withErrors([$exc->getMessage()])
                    ->withInput();
            
       
        }
        
        return redirect('iuran');
    }
    
    public function store(Request $request) {
    
        $query = null;
        $add = true;
        $redirect_error = url()->previous();
        if($request->id){
            $query = Iuran::find($request->id);
            
            if($request->user()->rt != $query->rt_id){
                return redirect($redirect_error)
                    ->withErrors(["Anda tidak berhak mengubah data ini"])
                    ->withInput();
            }
            
            $iuran_bayar = Iuranbayar::where('iuran_id',$request->id)->first();
            $add = false;
            if($iuran_bayar){
                return redirect($redirect_error)
                    ->withErrors(['Bulan '.Master::$BULAN[$request->bulan].' '.$request->tahun.' tidak bisa di ubah karena sudah ada yang bayar'])
                    ->withInput();
            }
        }else{
            $query = new Iuran($request->all());
        }
        
        $cek_exists = Iuran::where('bulan',$request->bulan)
                ->where('rt_id',$request->user()->rt)
                ->where('tahun',$request->tahun)->first();
        
        if($cek_exists && $add){
             return redirect($redirect_error)
                    ->withErrors(['Bulan '.Master::$BULAN[$request->bulan].' '.$request->tahun.' sudah ada'])
                    ->withInput();
        }
        
        try {  
            DB::beginTransaction();
            $komponen = Iuranjenis::where('rt_id',$request->user()->rt)->get();
            $komp = [];
            foreach ($komponen as $val) {
                $komp[] = $val->nama_iuran;
            }
            if (!$add) {
                Iurankomponen::where('iuran_id', $query->id)->delete();
            }
            if ($add) {
                $query->rt_id = $request->user()->rt;
                $query->save();
            } else {
                $query->update($request->all());
            }
            foreach ($komp as $value) {
                if (isset($request->$value) && $request->$value) {
                    $attribute = [
                        'iuran_id' => $query->id,
                        'nama_iuran' => $value,
                        'jumlah' => $request->{$value . '_jumlah'},
                    ];
                    $query_komponen = new Iurankomponen($attribute);
                    $query_komponen->save();
                }
            }
            DB::commit();
        } catch (\Exception $exc) {
            DB::rollBack();
            return redirect($redirect_error)
                    ->withErrors([$exc->getMessage()])
                    ->withInput();
            
       
        }
        
        return redirect('iuran');
    }
    
   
}
