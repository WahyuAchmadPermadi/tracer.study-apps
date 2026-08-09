<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('alumni.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nim' => 'required',
            'tanggal_lahir' => 'required|date',
        ]);

        $alumni = Alumni::where('nim', $request->nim)
            ->where('tanggal_lahir', $request->tanggal_lahir)
            ->first();

        if (!$alumni) {
            return back()
                ->withInput()
                ->withErrors([
                    'login' => 'NIM atau Tanggal Lahir tidak sesuai.'
                ]);
        }

        session([
            'alumni_login' => true,
            'alumni_nim' => $alumni->nim,
            'alumni_nama' => $alumni->nama,
        ]);

        return redirect()->route('alumni.dashboard');
    }

    public function logout()
    {
        session()->forget([
            'alumni_login',
            'alumni_nim',
            'alumni_nama',
        ]);

        return redirect()->route('alumni.login');
    }
}