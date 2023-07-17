<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {
  public function login(Request $request)   {
    $validasi   = Validator::make($request->all(), [
      'email' => 'required_without:username',
      'username' => 'required_without:email',
      'password' => 'required|min:6',
    ]);

    if ($validasi->fails()) {
      return $this->error($validasi->errors()->first());
    }

    $user   =   $user = User::where(function ($query) use ($request) {
                $query->where('email', $request->input('email'))
               ->orWhere('username', $request->input('username'));
               })->first();
    
    if ($user) {

        if (password_verify($request->password, $user->password)) {
          return  $this->success($user);
        } else {
          return  $this->error("Password salah");
        }
        
    }
    return $this->error("User tidak ditemukan");
  }  

  public function register (Request $request) {
    $validasi   = Validator::make($request->all(), [
      'email' => 'required|unique:users',
      'username' => 'required|unique:users',
      'nama' => 'required',
      'password' => 'required|min:6',
    ]);

    if ($validasi->fails()) {
      return $this->error($validasi->errors()->first());
    }

    $user = User::create(array_merge($request->all(), [
      'password'  => bcrypt($request->password),
      'role' => 'user'
    ]));

    if  ($user)  {
      return $this->success($user, 'Selamat Datang  '. $user->nama);
    } else  {
      return $this->error("Terjadi Kesalahan");
    }

  }

  public function success($data, $message = "success") {
    return  response()->json([
      'code'  =>  200,
      'message' =>  $message,
      'data'  => $data
    ]);
  }

  public function error($message) {
    // return  response()->json([
    //   'code'  =>  400,
    //   'message' =>  $message
    // ],  400);
    return  response()->json([
      'ok'  => false,
      'error_code'  =>  400,
      'description' =>  $message
    ],  400);
  }

}
