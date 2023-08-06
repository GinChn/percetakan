<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function tampilUbah()
    {
        return view('login.ubah_password');
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
        return back()->withInput()->with('gagal-login', 'Username atau Password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    function lupaPassword()
    {
        return view('login.reset_password');
    }

    function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'username' => 'required|email|exists:users',
        ]);

        // Ambil data user berdasarkan email
        $user = User::where('username', $request->username)->first();

        if ($user) {
            $token = Str::random(64);

            DB::table('password_resets')->insert([
                'email' => $request->username,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            Mail::send('emails.forgetPassword', [
                'token' => $token,
                'nama_pengguna' => $user->nama // Menggunakan kolom 'nama' dari tabel users
            ], function ($message) use ($request) {
                $message->to($request->username);
                $message->subject('Reset Password');
            });

            return back()->with('status', 'Kami telah mengirimkan tautan ke email Anda!');
        } else {
            return back()->withErrors(['username' => 'Email tidak ditemukan']);
        }
    }


    public function showResetPasswordForm($token)
    {
        return view('login.ubah_password', ['token' => $token]);
    }


    public function submitResetPasswordForm(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Check if the token exists in the password_resets table and get the associated username
        $passwordReset = DB::table('password_resets')
            ->where('token', $request->token)
            ->first();

        if (!$passwordReset) {
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $username = $passwordReset->email;

        // Update the user's password
        $user = User::where('username', $username)
            ->update(['password' => Hash::make($request->password)]);

        // Remove the password reset record from the table
        DB::table('password_resets')->where(['email' => $username])->delete();

        return redirect('/login')->with('message', 'Password Anda Berhasil Diubah!');
    }
}
