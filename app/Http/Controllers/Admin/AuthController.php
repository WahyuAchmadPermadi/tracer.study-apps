<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;


class AuthController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }
    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if (!$admin) {
            return back()->with('error', 'Username tidak ditemukan');
        }

        if (!Hash::check($request->password, $admin->password)) {
            return back()->with('error', 'Password salah');
        }

        session([
            'admin_id' => $admin->id_admin,
            'admin_nama' => $admin->nama,
        ]);

        return redirect('/admin/dashboard');//
    }
    public function logout()
    {
        session()->flush();

        return redirect('/admin/login');
    }
}
