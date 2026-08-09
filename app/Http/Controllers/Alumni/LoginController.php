<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        return view('alumni.login');
    }//
}
