<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\JawabanTracer;
use Illuminate\Http\Request;

class JawabanTracerController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $tahunLulus = $request->query('tahun_lulus');
        $programStudi = $request->query('program_studi');

        $programStudis = Alumni::PROGRAM_STUDIS;

        if (!in_array($programStudi, $programStudis, true)) {
            $programStudi = null;
        }

        $tahunLulusOptions = Alumni::query()
            ->whereNotNull('tahun_lulus')
            ->distinct()
            ->orderByDesc('tahun_lulus')
            ->pluck('tahun_lulus');

        $jawaban = JawabanTracer::with('alumni')
            ->whereNotNull('submitted_at')
            ->whereHas('alumni', function ($query) use ($search, $tahunLulus, $programStudi) {
                if ($search !== '') {
                    $query->where(function ($query) use ($search) {
                        $query->where('nim', 'like', "%{$search}%")
                            ->orWhere('nama', 'like', "%{$search}%");
                    });
                }

                if ($tahunLulus) {
                    $query->where('tahun_lulus', $tahunLulus);
                }

                if ($programStudi) {
                    $query->where('program_studi', $programStudi);
                }
            })
            ->orderByDesc('id_jawaban')
            ->paginate(10)
            ->withQueryString();

        return view('admin.jawaban_tracer.index', compact(
            'jawaban',
            'search',
            'tahunLulus',
            'programStudi',
            'tahunLulusOptions',
            'programStudis'
        ));
    }

    public function show($id)
    {
        $jawaban = JawabanTracer::with('alumni')
            ->findOrFail($id);

        return view('admin.jawaban_tracer.show', compact('jawaban'));
    }
}
