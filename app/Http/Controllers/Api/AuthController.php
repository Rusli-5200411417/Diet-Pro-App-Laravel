<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
  public function login()   {

if(!$request->email)    {
    return  "Email tidak boleh kosong";
}

    $user   =   User::where('email', $request->email)->first();
    if (user) {
        return  "Berhasil Masuk".$user->name;
    }
    return "User tidak ditemukan";
  }  
}
