<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class LoginController extends Controller
{
    public function index()
    {
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

            // jika login berhasil
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Login successful.']);
            }

            return redirect()->intended('/dashboard');
        }

        // jika login gagal
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Username or Password is incorrect.'], 401);
        }
        return back()->with('gagal-login', 'Username atau Password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    function resetPassword()
    {
        return view('login.reset_password');
    }
}
