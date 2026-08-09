<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\JawabanTracer;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | TOTAL ALUMNI
        |--------------------------------------------------------------------------
        */

        $totalAlumni = Alumni::count();


        /*
        |--------------------------------------------------------------------------
        | ALUMNI SUDAH MENGISI KUESIONER
        |--------------------------------------------------------------------------
        |
        | Hanya dihitung jika kuesioner sudah benar-benar dikirim.
        |
        */

        $sudahIsi = JawabanTracer::whereNotNull('submitted_at')->count();


        /*
        |--------------------------------------------------------------------------
        | ALUMNI BELUM MENGISI
        |--------------------------------------------------------------------------
        */

        $belumIsi = $totalAlumni - $sudahIsi;


        /*
        |--------------------------------------------------------------------------
        | PERSENTASE RESPON
        |--------------------------------------------------------------------------
        */

        $persentase = 0;

        if ($totalAlumni > 0) {

            $persentase = round(
                ($sudahIsi / $totalAlumni) * 100,
                2
            );

        }


        /*
        |--------------------------------------------------------------------------
        | JUMLAH RESPONDEN BERDASARKAN PROGRAM STUDI
        |--------------------------------------------------------------------------
        */

        $programStudi = Alumni::join(
                'jawaban_tracer',
                'alumnis.nim',
                '=',
                'jawaban_tracer.nim'
            )
            ->whereNotNull('jawaban_tracer.submitted_at')
            ->select(
                'alumnis.program_studi',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('alumnis.program_studi')
            ->orderBy('alumnis.program_studi')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view('admin.dashboard', compact(
            'totalAlumni',
            'sudahIsi',
            'belumIsi',
            'persentase',
            'programStudi'
        ));
    }
}