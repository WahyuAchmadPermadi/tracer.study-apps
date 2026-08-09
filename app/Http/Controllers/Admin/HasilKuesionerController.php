<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResponKuesioner;
use App\Models\JawabanKuesioner;

class HasilKuesionerController extends Controller
{
    public function index()
    {
        $respon = ResponKuesioner::with('alumni')
                    ->latest()
                    ->get();

        return view('admin.hasil.index', compact('respon'));
    }

    public function show($id)
    {
        $respon = ResponKuesioner::with('alumni')
                    ->findOrFail($id);

        $jawaban = JawabanKuesioner::with('kuesioner')
                    ->where('id_respon', $id)
                    ->orderBy('id_kuesioner')
                    ->get();

        return view('admin.hasil.show', compact('respon','jawaban'));
    }
}