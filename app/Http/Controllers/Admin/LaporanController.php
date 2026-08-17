<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\PeriodeTracer;
use Illuminate\Http\Request;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN LAPORAN
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $tahun = Alumni::select('tahun_lulus')
            ->whereNotNull('tahun_lulus')
            ->distinct()
            ->orderBy('tahun_lulus')
            ->pluck('tahun_lulus');

        $prodi = Alumni::select('program_studi')
            ->whereNotNull('program_studi')
            ->distinct()
            ->orderBy('program_studi')
            ->pluck('program_studi');

        $laporan = collect();
        $periode = PeriodeTracer::query()->orderByDesc('tahun')->get();

        return view('admin.laporan.index', compact(
            'tahun',
            'prodi',
            'periode',
            'laporan'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | FILTER LAPORAN
    |--------------------------------------------------------------------------
    */
    public function filter(Request $request)
    {
        $query = $this->queryLaporan(
            $request->tahun_lulus,
            $request->program_studi,
            $request->status,
            $request->id_periode
        );

        $laporan = $query
            ->orderBy('tahun_lulus', 'desc')
            ->orderBy('nama')
            ->get();

        session([
            'laporan.tahun_lulus'   => $request->tahun_lulus,
            'laporan.program_studi' => $request->program_studi,
            'laporan.status'        => $request->status,
            'laporan.id_periode'    => $request->id_periode,
        ]);

        $tahun = Alumni::select('tahun_lulus')
            ->whereNotNull('tahun_lulus')
            ->distinct()
            ->orderBy('tahun_lulus')
            ->pluck('tahun_lulus');

        $prodi = Alumni::select('program_studi')
            ->whereNotNull('program_studi')
            ->distinct()
            ->orderBy('program_studi')
            ->pluck('program_studi');
        $periode = PeriodeTracer::query()->orderByDesc('tahun')->get();

        return view('admin.laporan.index', compact(
            'laporan',
            'tahun',
            'prodi'
            ,'periode'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | QUERY LAPORAN
    |--------------------------------------------------------------------------
    */
    private function queryLaporan(
        $tahunLulus = null,
        $programStudi = null,
        $status = null,
        $idPeriode = null
    ) {
        $jawabanScope = function ($query) use ($idPeriode) {
            if ($idPeriode) {
                $query->where('id_periode', $idPeriode);
            }
        };

        $query = Alumni::with(['jawabanTracer' => $jawabanScope]);

        if (!empty($tahunLulus)) {
            $query->where('tahun_lulus', $tahunLulus);
        }

        if (!empty($programStudi)) {
            $query->where('program_studi', $programStudi);
        }

        if ($status === 'sudah') {

            $query->whereHas('jawabanTracer', function ($q) use ($idPeriode) {
                $q->whereNotNull('submitted_at');
                if ($idPeriode) $q->where('id_periode', $idPeriode);
            });

        } elseif ($status === 'belum') {

            $query->whereDoesntHave('jawabanTracer', function ($q) use ($idPeriode) {
                $q->whereNotNull('submitted_at');
                if ($idPeriode) $q->where('id_periode', $idPeriode);
            });
        }

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    */
    public function exportExcel()
    {
        return Excel::download(
            new LaporanExport(
                session('laporan.tahun_lulus'),
                session('laporan.program_studi'),
                session('laporan.status'),
                session('laporan.id_periode')
            ),
            'Laporan_Tracer_Study_' . date('Y-m-d') . '.xlsx'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF
    |--------------------------------------------------------------------------
    */
    public function exportPdf()
    {
        $tahunLulus   = session('laporan.tahun_lulus');
        $programStudi = session('laporan.program_studi');
        $status       = session('laporan.status');
        $idPeriode    = session('laporan.id_periode');

        $alumni = $this->queryLaporan(
            $tahunLulus,
            $programStudi,
            $status,
            $idPeriode
        )
        ->orderBy('tahun_lulus', 'desc')
        ->orderBy('nama')
        ->get();

        $totalAlumni = $alumni->count();

        $sudahMengisi = $alumni->filter(function ($item) {

            return $item->jawabanTracer
                && $item->jawabanTracer->submitted_at;

        })->count();

        $belumMengisi = $totalAlumni - $sudahMengisi;

        $persentase = $totalAlumni > 0
            ? round(($sudahMengisi / $totalAlumni) * 100, 2)
            : 0;

        $data = [
            'alumni'        => $alumni,
            'tahun'         => $tahunLulus,
            'prodi'         => $programStudi,
            'status'        => $status,
            'idPeriode'     => $idPeriode,
            'totalAlumni'   => $totalAlumni,
            'sudahMengisi'  => $sudahMengisi,
            'belumMengisi'  => $belumMengisi,
            'persentase'    => $persentase,
            'tanggalCetak'  => now()->format('d-m-Y'),
        ];

        /*
        |--------------------------------------------------------------------------
        | GENERATE PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            'admin.laporan.pdf',
            $data
        );

        $pdf->setPaper('a4', 'landscape');

        /*
        |--------------------------------------------------------------------------
        | SIMPAN PDF SEMENTARA
        |--------------------------------------------------------------------------
        */

        $namaFile = 'Laporan_Tracer_Study_' . date('Y-m-d_H-i-s') . '.pdf';

        $folder = storage_path('app/temp');

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $path = $folder . DIRECTORY_SEPARATOR . $namaFile;

        file_put_contents(
            $path,
            $pdf->output()
        );

        /*
        |--------------------------------------------------------------------------
        | PASTIKAN FILE BERHASIL DIBUAT
        |--------------------------------------------------------------------------
        */

        if (!file_exists($path)) {
            abort(500, 'File PDF gagal dibuat.');
        }

        if (filesize($path) === 0) {
            abort(500, 'File PDF kosong.');
        }

        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD
        |--------------------------------------------------------------------------
        */

        return response()
            ->download(
                $path,
                $namaFile,
                [
                    'Content-Type' => 'application/pdf',
                ]
            )
            ->deleteFileAfterSend(true);
    }
}
