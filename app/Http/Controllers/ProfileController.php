<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Level;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
// use Illuminate\Foundation\Auth\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profile.index', [
            'profile' => User::where('id_user', '=', auth()->user()->id_user)->first()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('profile.edit', [
            'profile' => User::where('id_user', '=', $id)->first(),
            'level' => Level::all()
        ]);
    }

    public function formGantiPassword()
    {
        return view('profile.ganti_password');
    }

    public function gantiPassword(Request $request)
    {
        $userId = Auth::id(); // Get the authenticated user's ID
        $password_lama = $request->input('password_lama');
        $password_baru = $request->input('password_baru');
        $konfirmasi_password = $request->input('konfirmasi_password');

        // Custom validation messages
        $customMessages = [
            'password_lama.required' => 'Password lama harus diisi.',
            'password_baru.required' => 'Password baru harus diisi.',
            'password_baru.min' => 'Password baru minimal harus :min karakter.',
            'konfirmasi_password.required' => 'Konfirmasi password baru harus diisi.',
            'konfirmasi_password.same' => 'Konfirmasi password baru harus sama dengan password baru.',
        ];

        // Validasi input with custom messages
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:5',
            'konfirmasi_password' => 'required|same:password_baru',
        ], $customMessages);

        // Retrieve the user from the User model
        $user = User::find($userId);

        // Periksa apakah password lama cocok dengan password di database
        if (Hash::check($password_lama, $user->password)) {
            // Hash password baru
            $hashed_password = Hash::make($password_baru);

            // Update password user

            $user->update(['password' => $hashed_password]);
            Auth::login($user);

            return redirect()->route('profile.index')->with('success', 'Password berhasil diubah.');
        } else {
            return redirect()->back()->with('error', 'Password lama salah.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        User::where('id_user', '=', $id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'pendidikan' => $request->pendidikan
        ]);

        return redirect('/profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
