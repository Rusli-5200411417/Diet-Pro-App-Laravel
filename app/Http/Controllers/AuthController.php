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
            $user = Auth::user();

            if ($user->role == 'admin') {
                Session::flash('success', 'Login Successful!');
                return redirect()->route('dashboard');
            } else {
                Auth::logout();
                $validator->errors()->add('', 'You are not authorized to access this dashboard.');
                return redirect()->route('login')->withErrors($validator)->withInput();
            }
        }

        $validator->errors()->add('error', 'Invalid username or password. Please try again.');
        return redirect()->route('login')->withErrors($validator)->withInput();
    }

    
    

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }
    
}
