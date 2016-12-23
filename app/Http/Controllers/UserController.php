<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use PDF;
use App\Log;
use Excel;
use DB;
use Validator;
use Auth;

class UserController extends Controller {

    public function index(Request $request) {
        
        $limit = $request->limit ? $request->limit : 10;
        $query = User::with(['roles' => function($q){
                            $q->select('roles.id','name','slug');
                        }])->where('rt',$request->user()->rt)
                                ->paginate($limit);
        $page = $request->page ? $request->page : 1;
        $no = ($page-1) * $limit + 1;
        $Data = $query->toArray();
        $data = [
            'data' => $Data['data'],
            'pagination' => $query,
            'no' => $no,
        ];
        return view('sbadmin2.user.index', $data);
        
    }
    
    public function show(Request $request, $id) {
        $user_login = $request->user();
        $user = User::find($id);
        return view('sbadmin2.user.show', $user);
    }
    
    public function create(Request $request) {
        $rt = $request->user()->rt;
        
        $query['password_required'] = "required";
        $query['kepalakeluarga'] = User::where('keluarga_dari',0)
                ->where('rt',$rt)->get();
        $query['keluarga_dari'] = 0;
        $query['is_menetap'] = 1;
        $query['status_keluarga'] = 1;
        $query['agama'] = 1;
        $query['rt'] = $rt;
        
        return view('sbadmin2.user.form',$query);
    }
    
    public function edit($id) {
        $query = User::find($id);
        $query->password_required = false;
        $query->kepalakeluarga = User::where('keluarga_dari',0)->get();
        return view('sbadmin2.user.form', $query);
    }
    
    public function store(Request $request) {
        
        $query = null;
        $add = true;
        $redirect_error = url()->previous();
        if($request->id){
            $query = User::find($request->id);
            $add = false;
        }else{
            $query = new User;
        }    
        $reqs = $request->all();
        try {      
        foreach ($reqs as $key => $value) {
            if($key != 'password_confirmation' && $value && $key !='_token' && $key !='thn'){
                if($key == 'password'){
                    $query->{$key} = bcrypt($value);
                }else{
                    $query->{$key} = $value;
                }
            }
        }
        $query->rt = $request->user()->rt;
        if(Auth::user()->is('administrator')){
            $query->rt = $request->rt;
        }
        
        $query->save();
        if($add){
            $query->assignRole('warga_rt');
        }
        } catch (\Exception $exc) {
            return redirect($redirect_error)
                    ->withErrors([$exc->getMessage()])
                    ->withInput();
            
            return $redir;
       
        }
        
        return redirect('user');
    }
    
    public function editrole($id) {
        $user = User::find($id);
        $user->administrator = $user->is('administrator');
        $user->ketua_rt = $user->is('ketua_rt') ;
        $user->sekretaris_rt = $user->is('sekretaris_rt') ;
        $user->bendahara_rt = $user->is('bendahara_rt') ;
        $user->warga_rt = $user->is('warga_rt') ;
        return view('sbadmin2.user.formeditrole', $user);
    }
    
    public function updaterole(Request $request, $id) {
        $userlogin = $request->user();
        $user = User::find($id);
        
        if($request->administrator){
            $user->assignRole('administrator');
        }else{
            if($userlogin->id == $id){
                return redirect(url()->previous())
                            ->withErrors(['Maaf, Anda Tidak bisa menghapus role administrator anda'])
                            ->withInput();
            }else{
                $user->revokeRole('administrator');
            }
        }
        
        if($request->ketua_rt){
            $user->assignRole('ketua_rt');
        }else{
            $user->revokeRole('ketua_rt');
        }
            
        if($request->sekretaris_rt){
            $user->assignRole('sekretaris_rt');
        }else{
            $user->revokeRole('sekretaris_rt');
        }
        
        if($request->bendahara_rt){
            $user->assignRole('bendahara_rt');
        }else{
            $user->revokeRole('bendahara_rt');
        }
        
        if($request->warga_rt){
            $user->assignRole('warga_rt');
        }else{
            $user->revokeRole('warga_rt');
        }
        
        
        return redirect('user');
    }
}
