<?php

/*
  |--------------------------------------------------------------------------
  | Routes File
  |--------------------------------------------------------------------------
  |
  | Here is where you will register all of the routes in an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */



/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | This route group applies the "web" middleware group to every route
  | it contains. The "web" middleware group is defined in your HTTP
  | kernel and includes session state, CSRF protection, and more.
  |
 */



Route::group(['middleware' => ['web']], function () {
    Route::get('/tesemail/{email}',[
        'uses' => 'Auth\AuthController@tesemail',
        'as'   => 'auth.tesemail'
    ]);
    Route::get('/login/google',[
        'uses' => 'Auth\AuthController@getSocialAuth',
        'as'   => 'auth.getSocialAuth'
    ]);

    Route::get('/callback',[
        'uses' => 'Auth\AuthController@getSocialAuthCallback',
        'as'   => 'auth.getSocialAuthCallback'
    ]);

    Route::get('/registrasi/google',[
        'uses' => 'Auth\AuthController@getSocialAuth',
        'as'   => 'auth.getSocialAuth'
    ]);
    
    Route::get('/toko/{namatoko}', 'TokoController@index');
    Route::get('/toko/{namatoko}/{id_barang}', 'TokoController@show');
    
    Route::get('download/{id}', [
            'as' => 'download_order',
            'uses' => 'UploadController@download'
        ]);
    Route::post('upload', [
            'as' => 'upload_order',
            'uses' => 'UploadController@upload'
        ]);
    
    Route::get('api/provinsi', 'PropinsiController@provinsi');
    Route::get('api/kabupaten/{id_prov}', 'PropinsiController@kabupaten');
    Route::get('api/kecamatan/{id_kab}', 'PropinsiController@kecamatan');
    Route::get('api/kelurahan/{id_kec}', 'PropinsiController@kelurahan');
    
    Route::get('/login', function() {
        return view('karma.auth.login');
    });
    Route::post('/login', 'Auth\AuthController@login');
    Route::get('registrasi', function() {
        return view('karma.auth.register');
    });

    //eksekutif
    Route::get('/penawaranEterima/{id}', function($id) {
        return view('karma.penawaran.penawaranEterima',["id_penawaran"=>$id]);
    });
    Route::post('/konfirmasiTawaranE', 'PenawaranController@terimaE');

    Route::post('/registrasi', 'Auth\AuthController@create');
    Route::get('/aktivasi/{aktivasi_token}', 'Auth\AuthController@aktivasi');
//    Route::get('/aktivasi/{aktivasi_token}/ok', 'AnggotaController@aktivasi');
    Route::post('/aktivasi', [
        'as' => 'aktivasi',
        'uses' => 'Auth\AuthController@aktivasi'
    ]);
    Route::get('/updateuser/{user_id}', 'Auth\AuthController@updateuserform');
    Route::post('/updateuser', 'Auth\AuthController@updateuser');

    
    Route::post('/invoice', 'InvoiceController@store');
    //eksekutif
    Route::post('/invoiceEksekutif', 'InvoiceController@save');

    Route::post('/invoice/upload', [
        'as' => 'upload',
        'uses' => 'InvoiceController@upload'
    ]);
    Route::get('/invoice/{namafile}', [
        'as' => 'download',
        'uses' => 'InvoiceController@download'
    ]);
    
    Route::get('/', function () {
                return redirect('toko/admin');
            });
    Route::get('/password', 'PasswordController@index');
    Route::post('/resetPassword', 'PasswordController@send');

    Route::group(['middleware' => ['auth','notifikasi']], function () {
        
        Route::post('/toko/{namatoko}/order', 'TokoController@order');
        Route::get('/notifikasi', 'NotifikasiController@index');
        Route::get('/notifikasi/edit/{id}', 'NotifikasiController@update');
        Route::get('/invoice/create/{user_id}', 'InvoiceController@create');
        Route::get('/invoice/notifikasi/user', 'InvoiceController@notifikasi');
        
        //eksekutif
        Route::get('/invoice/eksekutif/{user_id}', 'InvoiceController@eksekutif');

        
        Route::get('/logout', function() {
                $auth = auth()->guard('user');
                $auth->logout();
                return redirect('login');
            });
        
//        Route::group(['middleware' => ['isverify']], function () {
            Route::get('/dashboard','DashboardController@index');


            //    
            //    Route::get('/profil', function() {
            //        $auth = auth()->guard('user');
            //        dd(Request::user());
            //    });
            //    
            

            //
            
            Route::get('/penawaran', 'PenawaranController@index');
            Route::get('/ditawari', 'PenawaranController@ditawari');
            Route::get('/penawaranterima/{id}', 'PenawaranController@terima');
            Route::get('/namatokoform/{id_penawaran}', 'PenawaranController@namatokoform');
            Route::post('/namatoko', 'PenawaranController@namatoko');
            Route::get('/penawarantolak/{id}', 'PenawaranController@tolak');
            Route::get('/tawari/{user_id}', 'AnggotaController@tawari');
            
            
            Route::get('/kategori', 'KategoriController@index');
            Route::get('/kategori/create', 'KategoriController@create');
            Route::post('/kategori', 'KategoriController@store');
            Route::get('/kategori/edit/{id}', 'KategoriController@edit');
            Route::post('/kategori/edit/{id}', 'KategoriController@update');
            Route::get('/kategori/{id}', 'KategoriController@show');

            Route::get('/lokasi', 'LokasiController@index');
            Route::get('/lokasi/create', 'LokasiController@create');
            Route::post('/lokasi', 'LokasiController@store');
            Route::get('/lokasi/edit/{id}', 'LokasiController@edit');
            Route::post('/lokasi/edit/{id}', 'LokasiController@update');
            Route::get('/lokasi/{id}', 'LokasiController@show');

            Route::get('/setting', 'SettingController@index');
            Route::get('/setting/create', 'SettingController@create');
            Route::post('/setting', 'SettingController@store');
            Route::get('/setting/edit/{id}', 'SettingController@edit');
            Route::post('/setting/edit/{id}', 'SettingController@update');
            Route::get('/setting/{id}', 'SettingController@show');


            Route::get('/anggota', 'AnggotaController@index');
            Route::get('/nonverify', 'AnggotaController@nonverify');
            Route::get('/anggota/create', 'AnggotaController@create');
            Route::get('/anggota/{id}', 'AnggotaController@show');
            Route::get('/verify/{id}', 'AnggotaController@verify');
            Route::post('/anggota', 'AnggotaController@store');

            Route::get('/profil', 'ProfilController@show');
            Route::get('/kodeafiliasi', 'ProfilController@kodeafiliasisaya');
            Route::get('/profil/edit', 'ProfilController@edit');
            Route::get('/profil/edit/avatar', 'ProfilController@editavatar');
            Route::post('/profil/edit', 'ProfilController@update');
            Route::post('/profil/edit/avatar', 'ProfilController@updateavatar');
            
            Route::get('/profil/edit/password', 'ProfilController@editpassword');
            Route::post('/profil/edit/password', 'ProfilController@updatepassword');
            

            Route::get('/barang', 'BarangController@index');
            Route::get('/barang/create', 'BarangController@create');
            Route::post('/barang', 'BarangController@store');
            Route::get('/barang/edit/{id}', 'BarangController@edit');
            Route::post('/barang/edit/{id}', 'BarangController@update');
            Route::get('/barang/{id}', 'BarangController@show');
            
            Route::get('/stok', 'StokController@index');
            Route::get('/stok/edit/{id}', 'StokController@edit');
            Route::post('/stok/edit/{id}', 'StokController@update');
            
            Route::get('/order', 'OrderbeliController@index');
            Route::get('/order/create', 'OrderbeliController@create');
            Route::get('/orderconfirm', 'OrderbeliController@confirm');
            Route::post('/order', 'OrderbeliController@store');
            Route::post('/orderpoin', 'OrderbeliController@storepoin');
            Route::post('/order/tmp', 'OrderbeliController@storetmp');
            Route::get('/order/tmp/create', 'OrderbeliController@tambahform');
            Route::get('/order/tmp/batal', 'OrderbeliController@batal');
            Route::get('/ordertmp/{id}/delete', 'OrderbeliController@destroytmp');
            Route::get('/order/{id}', 'OrderbeliController@show');
            
            Route::get('/jual', 'OrderjualController@index');
            Route::get('/jual/verify/{id}', 'OrderjualController@verify');
            Route::get('/jual/{id}', 'OrderjualController@show');
            
            
            Route::get('/point', 'PointController@show');
            Route::get('/fee', 'affiliateController@index');

            //penawaran eksekutif

            Route::get('/penawaranEksekutif', 'AnggotaController@listAnggota');
            Route::get('/upgrade/{id}', 'AnggotaController@upgrade');
            

        });
//    });

//    Route::auth();
        
        
//        $this->get('login', 'Auth\AuthController@showLoginForm');
//    $this->post('login', 'Auth\AuthController@login');
//    $this->get('logout', 'Auth\AuthController@logout');
//
//    // Registration Routes...
//    $this->get('register', 'Auth\AuthController@showRegistrationForm');
//    $this->post('register', 'Auth\AuthController@register');

    // Password Reset Routes...
//    $this->get('password/reset', 'Auth\PasswordController@showResetForm');
//    $this->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
//    $this->post('password/reset', 'Auth\PasswordController@reset');
    


    
});
