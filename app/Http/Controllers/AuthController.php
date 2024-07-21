<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if ($user = Auth::user()) {
            if ($user->role == 'admin') {
                return redirect()->route('dashboard');
            } elseif ($user->role == 'pengawas') {
                return redirect()->route('pengawas.dashboard');
            }
        }
        return view('auth.login');
    }

    public function proses_login(Request $request)
    {
        request()->validate(
            [
                'email' => 'required',
                'password' => 'required',
            ]
        );

        $kredensil = $request->only('email', 'password');

        if (Auth::attempt($kredensil)) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                return redirect()->route('dashboard');
            } elseif ($user->role == 'pengawas') {
                return redirect()->route('pengawas.dashboard');
            }
            return redirect()->intended('/');
        }
        // return redirect('login')->withToastError('Email atau Password Salah !');
        // Custom error messages for email and password
        return back()->withErrors([
            'email' => 'Email yang Anda masukkan salah.',
            'password' => 'Password yang Anda masukkan salah.',
        ])->withInput($request->only('email'));
    }

    public function register()
    {
        return view('auth.register');
    }

    public function proses_registrasi(Request $request)
    {
        User::create([
            'name' => $request->name,
            'username' => Str::lower(str_replace(' ', '', $request->name)),
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'pengawas'
        ]);
        return redirect()->route('login')->withToastSuccess('Registrasi Berhasil');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('login');
    }
}
