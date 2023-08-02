<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $user = User::where('role', 'user')->get();
        return view('dashboard' ,compact('user')) ;
    }
}
