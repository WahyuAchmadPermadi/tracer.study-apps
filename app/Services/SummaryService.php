<?php

namespace App\Services;

use App\Models\JawabanTracer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SummaryService
{
    /**
     * Dashboard Summary
     */
    public function getDashboard(Request $request): array
    {
        $query = JawabanTracer::query()
            ->join('alumnis', 'jawaban_tracer.nim', '=', 'alumnis.nim')
            ->whereNotNull('jawaban_tracer.submitted_at');

        /*
        |--------------------------------------------------------------------------
        | Filter Tahun Lulus
        |--------------------------------------------------------------------------
        */

        $query->when(
            $request->filled('tahun_lulus'),
            fn ($q) => $q->where(
                'alumnis.tahun_lulus',
                $request->tahun_lulus
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Filter Program Studi
        |--------------------------------------------------------------------------
        */

        $query->when(
            $request->filled('kode_program_studi'),
            fn ($q) => $q->where(
                'alumnis.kode_program_studi',
                $request->kode_program_studi
            )
        );

        return [

            'summary' => $this->summaryCards(clone $query),

            'average' => $this->averageCards(clone $query),

            'charts' => [

                'status' => $this->statusChart(clone $query),

                'jenis_perusahaan' => $this->pieChart(
                    clone $query,
                    'jenis_perusahaan'
                ),

                'tingkat_tempat_kerja' => $this->pieChart(
                    clone $query,
                    'tingkat_tempat_kerja'
                ),

                'hubungan_bidang' => $this->pieChart(
                    clone $query,
                    'hubungan_bidang'
                ),

                'kabupaten' => $this->barChart(
                    clone $query,
                    'kabupaten'
                ),

                'provinsi' => $this->barChart(
                    clone $query,
                    'provinsi'
                ),

            ],

            'tables' => [

                'perusahaan' => $this->topCompanies(
                    clone $query
                ),

                'jabatan' => $this->topPositions(
                    clone $query
                ),

            ],

        ];
    }

    /**
     * ============================================================
     * SUMMARY CARD
     * ============================================================
     */

    private function summaryCards(Builder $query): array
    {
        $total = (clone $query)->count();

        $bekerja = (clone $query)
            ->where(function ($q) {

                $q->where('status', 'LIKE', '%Bekerja%')
                    ->orWhere('status', 'LIKE', '%Wiraswasta%');

            })
            ->count();

        $studi = (clone $query)
            ->where('status', 'Melanjutkan Pendidikan')
            ->count();

        $mencari = (clone $query)
            ->where(
                'status',
                'Tidak kerja tetapi sedang mencari kerja'
            )
            ->count();

        return [

            'total' => $total,

            'bekerja' => $bekerja,

            'studi' => $studi,

            'mencari' => $mencari,

            'persen_bekerja' =>
                $total > 0
                    ? round($bekerja / $total * 100)
                    : 0,

            'persen_studi' =>
                $total > 0
                    ? round($studi / $total * 100)
                    : 0,

            'persen_mencari' =>
                $total > 0
                    ? round($mencari / $total * 100)
                    : 0,

        ];
    }

    /**
     * ============================================================
     * PIE STATUS ALUMNI
     * ============================================================
     */

    private function statusChart(Builder $query): array
    {
        $rows = (clone $query)
            ->select(
                'status',
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull('status')
            ->where('status', '<>', '')
            ->groupBy('status')
            ->orderByDesc('total')
            ->get();

        return [
            'labels' => $rows->pluck('status')->values()->toArray(),
            'data' => $rows->pluck('total')->map(fn ($v) => (int) $v)->values()->toArray(),
        ];
    }

    /**
     * ============================================================
     * RATA-RATA
     * ============================================================
     */

    private function averageCards(Builder $query): array
    {
        return [

            'pendapatan' => round(
                (clone $query)->avg('pendapatan') ?? 0
            ),

            'mulai_mencari' => $this->averageMonthDifference(
                clone $query,
                'mulai_mencari_kerja'
            ),

            'pekerjaan_pertama' => $this->averageMonthDifference(
                clone $query,
                'pekerjaan_pertama'
            ),

        ];
    }
        /**
     * ============================================================
     * PIE CHART
     * ============================================================
     */
    private function pieChart(
        Builder $query,
        string $field
    ): array {

        $rows = (clone $query)
            ->select(
                $field,
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull($field)
            ->where($field, '<>', '')
            ->groupBy($field)
            ->orderByDesc('total')
            ->get();

        return [

            'labels' => $rows
                ->pluck($field)
                ->values()
                ->toArray(),

            'data' => $rows
                ->pluck('total')
                ->map(fn ($v) => (int) $v)
                ->values()
                ->toArray(),

        ];
    }

    /**
     * ============================================================
     * HORIZONTAL BAR
     * ============================================================
     */
    private function barChart(
        Builder $query,
        string $field
    ): array {

        $rows = (clone $query)
            ->select(
                $field,
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull($field)
            ->where($field, '<>', '')
            ->groupBy($field)
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return [

            'labels' => $rows
                ->pluck($field)
                ->values()
                ->toArray(),

            'data' => $rows
                ->pluck('total')
                ->map(fn ($v) => (int) $v)
                ->values()
                ->toArray(),

        ];
    }

    /**
     * ============================================================
     * TOP 10 PERUSAHAAN
     * ============================================================
     */
    private function topCompanies(
        Builder $query
    ) {

        return (clone $query)

            ->select(
                'nama_perusahaan',
                DB::raw('COUNT(*) as total')
            )

            ->whereNotNull('nama_perusahaan')

            ->where('nama_perusahaan', '<>', '')

            ->groupBy('nama_perusahaan')

            ->orderByDesc('total')

            ->limit(10)

            ->get();
    }

    /**
     * ============================================================
     * TOP 10 JABATAN
     * ============================================================
     */
    private function topPositions(
        Builder $query
    ) {

        return (clone $query)

            ->select(
                'jabatan',
                DB::raw('COUNT(*) as total')
            )

            ->whereNotNull('jabatan')

            ->where('jabatan', '<>', '')

            ->groupBy('jabatan')

            ->orderByDesc('total')

            ->limit(10)

            ->get();
    }

    /**
     * ============================================================
     * RATA-RATA SELISIH BULAN
     * ============================================================
     *
     * Menghitung rata-rata selisih bulan antara
     * tahun lulus dan field YYYY-MM.
     */
    private function averageMonthDifference(
        Builder $query,
        string $field
    ): int {

        $rows = (clone $query)
            ->select(
                'alumnis.tahun_lulus',
                "jawaban_tracer.$field"
            )
            ->whereNotNull("jawaban_tracer.$field")
            ->where("jawaban_tracer.$field", '<>', '')
            ->get();

        if ($rows->isEmpty()) {
            return 0;
        }

        $totalMonths = 0;
        $count = 0;

        foreach ($rows as $row) {

            $value = trim((string) $row->$field);

            /*
            |--------------------------------------------------------------------------
            | Mendukung format:
            | YYYY-MM
            | YYYY-MM-DD
            |--------------------------------------------------------------------------
            */

            if (!preg_match('/^\d{4}-\d{2}(-\d{2})?$/', $value)) {
                continue;
            }

            $parts = explode('-', $value);

            $year = (int) $parts[0];
            $month = (int) $parts[1];

            $graduateYear = (int) $row->tahun_lulus;

            // Diasumsikan bulan lulus Januari
            $graduateMonth = 1;

            $difference =
                (($year - $graduateYear) * 12)
                + ($month - $graduateMonth);

            if ($difference < 0) {
                continue;
            }

            $totalMonths += $difference;
            $count++;
        }

        if ($count === 0) {
            return 0;
        }

        return (int) round($totalMonths / $count);
    }
}