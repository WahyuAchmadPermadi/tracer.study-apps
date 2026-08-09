<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\JawabanTracer;

class DashboardController extends Controller
{
    public function index()
    {
        $alumni = Alumni::findOrFail(session('alumni_nim'));

        $respon = JawabanTracer::where('nim', $alumni->nim)->first();

        return view('alumni.dashboard', compact(
            'alumni',
            'respon'
        ));
    }
}