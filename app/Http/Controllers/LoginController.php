<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('login.index');
    }

    public function login(Request $request)
    {
        $cekuser = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        
        if (Auth::attempt($cekuser)) {
            $request->session()->regenerate();
            
            return redirect()->intended('/');
        }
        
        return back()->with('gagal-login', 'Username atau Password salah');
    }

    public function logout(Request $request){
        Auth::logout();
        
        $request->session()->invalidate();
        
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}
