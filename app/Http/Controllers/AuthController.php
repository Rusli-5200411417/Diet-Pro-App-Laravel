<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login()
    {
     return view('login');
    }

    public function loginPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('login')->withErrors($validator)->withInput();
        }
    
        $credentials = $request->only('username', 'password');
    
        if (Auth::attempt($credentials)) {
            Session::flash('success', 'Login Successful!');
            return redirect()->route('dashboard');
        } else {
            $validator->errors()->add('username', 'Invalid username. Please try again.');
            $validator->errors()->add('password', 'Invalid password. Please try again.');
            return redirect()->route('login')->withErrors($validator)->withInput();
        }
    }
    
    

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }
    
}
