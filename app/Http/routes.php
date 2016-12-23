<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect('dashboard');
});
Route::get('home', function () {
    return redirect('dashboard');
});

Route::auth();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', 'DashboardController@index');
  
    Route::get('/urunan', 'UrunanController@index');
    Route::get('/urunan/create', 'UrunanController@create');
    Route::post('/urunan', 'UrunanController@store');
    Route::get('/urunan/edit/{id}', 'UrunanController@edit');
    Route::get('/urunan/delete/{id}', 'UrunanController@delete');
    Route::get('/api/urunan', 'UrunanController@apiurunan');
    
    Route::get('/urunan_bayar', 'UrunanbayarController@index');
    Route::get('/urunan_bayar/create/{iuran_id}/{user_id}', 'UrunanbayarController@store');
    Route::get('/urunan_bayar/delete/{iuran_id}/{user_id}', 'UrunanbayarController@delete');
    
    Route::post('/user', 'UserController@store');
    Route::get('/user', 'UserController@index');
    Route::get('/user/create', 'UserController@create');
    Route::get('/user/edit/{id}', 'UserController@edit');
    Route::get('/user/{id}', 'UserController@show');
    Route::get('/user/edit/{id}/role', 'UserController@editrole');
    Route::post('/user/update/{id}/role', 'UserController@updaterole');
    
    
    Route::get('/iuran', 'IuranController@index');
    Route::get('/iuran/create', 'IuranController@create');
    Route::post('/iuran', 'IuranController@store');
    Route::get('/iuran/edit/{id}', 'IuranController@edit');
    Route::get('/iuran/delete/{id}', 'IuranController@delete');
    
    Route::get('/jenis_iuran', 'IuranjenisController@index');
    Route::get('/jenis_iuran/create', 'IuranjenisController@create');
    Route::post('/jenis_iuran', 'IuranjenisController@store');
    Route::get('/jenis_iuran/edit/{id}', 'IuranjenisController@edit');
    Route::get('/jenis_iuran/delete/{id}', 'IuranjenisController@delete');
    
    Route::get('/bayar_iuran', 'IuranbayarController@index');
    Route::get('/bayar_iuran/create/{iuran_id}/{user_id}', 'IuranbayarController@store');
    Route::get('/bayar_iuran/delete/{iuran_id}/{user_id}', 'IuranbayarController@delete');
    
});


Route::get('oauth/authorize', ['as' => 'oauth.authorize.get', 'middleware' => ['check-authorization-params', 'auth'], function() {
//    $authParams = Authorizer::getAuthCodeRequestParams();

    $params = Authorizer::getAuthCodeRequestParams();
    $params['user_id'] = Auth::user()->id;
    $redirectUri = '/';
    $redirectUri = Authorizer::issueAuthCode('user', $params['user_id'], $params);

    return Redirect::to($redirectUri);
   
//   $formParams = array_except($authParams,'client');
//
//   $formParams['client_id'] = $authParams['client']->getId();
//
//   $formParams['scope'] = implode(config('oauth2.scope_delimiter'), array_map(function ($scope) {
//       return $scope->getId();
//   }, $authParams['scopes']));
//
//   return View::make('oauth.authorization-form', ['params' => $formParams, 'client' => $authParams['client']]);
}]);


Route::post('oauth/authorize', ['as' => 'oauth.authorize.post', 'middleware' => [ 'check-authorization-params', 'auth'], function() {

    $params = Authorizer::getAuthCodeRequestParams();
    $params['user_id'] = Auth::user()->id;
    $redirectUri = '/';

    // If the user has allowed the client to access its data, redirect back to the client with an auth code.
    if (Request::has('approve')) {
        $redirectUri = Authorizer::issueAuthCode('user', $params['user_id'], $params);
    }

    // If the user has denied the client to access its data, redirect back to the client with an error message.
    if (Request::has('deny')) {
        $redirectUri = Authorizer::authCodeRequestDeniedRedirectUri();
    }

    return Redirect::to($redirectUri);
}]);

Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

Route::group(['middleware' => ['auth-oauth','oauth:read']], function () {
    Route::get('userself', function (Request $request) {
            global $userlogin_id;
            $user = \App\User::find($userlogin_id);
          
            return Response::json($user);
        
    });
}); 