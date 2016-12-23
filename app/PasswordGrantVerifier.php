<?php
namespace App;

use Illuminate\Support\Facades\Auth;
use App\User;
class PasswordGrantVerifier
{
  public function verify($username, $password)
  {
      
        
      $credentials = [
        'email'    => $username,
        'password' => $password,
      ];

//      $user = User::where('email', '=', $email)
//              ->where('passwd', '=', md5($password))
//              ->where('is_aktif', '=', 1)
//              ->first();
//      if($user){
//          return $user->userid;
//      }
      if (Auth::once($credentials)) {
          return Auth::user()->id;
      }

      return false;
  }
}