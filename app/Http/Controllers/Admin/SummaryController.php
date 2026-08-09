<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Services\SummaryService;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    protected SummaryService $summaryService;

    public function __construct(SummaryService $summaryService)
    {
        $this->summaryService = $summaryService;
    }

    /**
     * Dashboard Summary
     */
    public function index(Request $request)
    {
        $dashboard = $this->summaryService->getDashboard($request);

        /*
        |--------------------------------------------------------------------------
        | Filter Tahun Lulus
        |--------------------------------------------------------------------------
        */

        $tahunLulus = Alumni::query()
            ->select('tahun_lulus')
            ->whereNotNull('tahun_lulus')
            ->distinct()
            ->orderByDesc('tahun_lulus')
            ->pluck('tahun_lulus');

        /*
        |--------------------------------------------------------------------------
        | Filter Program Studi
        |--------------------------------------------------------------------------
        */

        $programStudi = Alumni::query()
            ->select(
                'kode_program_studi',
                'program_studi'
            )
            ->whereNotNull('kode_program_studi')
            ->distinct()
            ->orderBy('program_studi')
            ->get();

        return view('admin.summary.index', [

            'dashboard' => $dashboard,

            'tahunLulus' => $tahunLulus,

            'programStudi' => $programStudi,

            'filter' => [

                'tahun_lulus' => $request->input('tahun_lulus'),

                'kode_program_studi' => $request->input('kode_program_studi'),

            ],

        ]);
    }
}