<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function tampilUser(){

        $users = User::where('role', 'user')->get();
        // dd($users);
        return view('user', compact('users'));
    }

    public function newUser(){
        $user = User::where('role', 'user')->where('created_at',  '>=', now()->startOfDay())->get(); 

            return view ('new-user',compact('user'));
    }
}
