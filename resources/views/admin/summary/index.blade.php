@extends('layouts.app')

@section('title', 'Dashboard Summary')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-pie-chart-fill text-primary"></i>
                Dashboard Summary
            </h3>

            <p class="text-muted mb-0">
                Ringkasan hasil Tracer Study Alumni
            </p>
        </div>

    </div>

    {{-- Filter --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header bg-white">

            <h5 class="mb-0">
                <i class="bi bi-funnel-fill"></i>
                Filter Data
            </h5>

        </div>

        <div class="card-body">

            <form method="GET" action="{{ route('summary.index') }}">

                <div class="row">

                    <div class="col-md-5 mb-3">

                        <label class="form-label fw-semibold">
                            Tahun Lulus
                        </label>

                        <select
                            name="tahun_lulus"
                            class="form-select">

                            <option value="">
                                Semua Tahun
                            </option>

                            @foreach($tahunLulus as $tahun)

                                <option
                                    value="{{ $tahun }}"
                                    @selected(($filter['tahun_lulus'] ?? '') == $tahun)>

                                    {{ $tahun }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-5 mb-3">

                        <label class="form-label fw-semibold">
                            Program Studi
                        </label>

                        <select
                            name="kode_program_studi"
                            class="form-select">

                            <option value="">
                                Semua Program Studi
                            </option>

                            @foreach($programStudi as $prodi)

                                <option
                                    value="{{ $prodi->kode_program_studi }}"
                                    @selected(($filter['kode_program_studi'] ?? '') == $prodi->kode_program_studi)>

                                    {{ $prodi->program_studi }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-2 d-grid mb-3">

                        <label class="form-label invisible">
                            Filter
                        </label>

                        <button
                            class="btn btn-primary">

                            <i class="bi bi-search"></i>

                            Terapkan

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- Summary Cards --}}
    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Total Responden
                            </small>

                            <h2 class="fw-bold mt-2">

                                {{ number_format($dashboard['summary']['total']) }}

                            </h2>

                        </div>

                        <div class="text-primary">

                            <i class="bi bi-people-fill fs-1"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Bekerja
                            </small>

                            <h2 class="fw-bold text-success mt-2">

                                {{ number_format($dashboard['summary']['bekerja']) }}

                            </h2>

                            <small>

                                {{ $dashboard['summary']['persen_bekerja'] }}%

                            </small>

                        </div>

                        <div class="text-success">

                            <i class="bi bi-briefcase-fill fs-1"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Studi Lanjut
                            </small>

                            <h2 class="fw-bold text-warning mt-2">

                                {{ number_format($dashboard['summary']['studi']) }}

                            </h2>

                            <small>

                                {{ $dashboard['summary']['persen_studi'] }}%

                            </small>

                        </div>

                        <div class="text-warning">

                            <i class="bi bi-mortarboard-fill fs-1"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Sedang Mencari Kerja
                            </small>

                            <h2 class="fw-bold text-danger mt-2">

                                {{ number_format($dashboard['summary']['mencari']) }}

                            </h2>

                            <small>

                                {{ $dashboard['summary']['persen_mencari'] }}%

                            </small>

                        </div>

                        <div class="text-danger">

                            <i class="bi bi-search fs-1"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Average Cards --}}
    <div class="row g-4 mb-4">

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">

                        Rata-rata Pendapatan

                    </h6>

                    <h3 class="fw-bold text-success">

                        Rp {{ number_format($dashboard['average']['pendapatan']) }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">

                        Mulai Mencari Kerja

                    </h6>

                    <h3 class="fw-bold text-primary">

                        {{ $dashboard['average']['mulai_mencari'] }}

                        Bulan

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">

                        Mendapatkan Pekerjaan Pertama

                    </h6>

                    <h3 class="fw-bold text-warning">

                        {{ $dashboard['average']['pekerjaan_pertama'] }}

                        Bulan

                    </h3>

                </div>

            </div>

        </div>

    </div>

    {{-- BAGIAN 2 DIMULAI DARI SINI --}}
    {{-- ==========================
    CHARTS
========================== --}}

<div class="row g-4 mb-4">

    {{-- Status Alumni --}}
    <div class="col-lg-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white">

                <strong>Status Alumni</strong>

            </div>

            <div class="card-body">

                <canvas id="statusChart"></canvas>

            </div>

        </div>

    </div>

    {{-- Jenis Perusahaan --}}
    <div class="col-lg-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white">

                <strong>Jenis Perusahaan</strong>

            </div>

            <div class="card-body">

                <canvas id="jenisPerusahaanChart"></canvas>

            </div>

        </div>

    </div>

</div>

<div class="row g-4 mb-4">

    {{-- Tingkat Tempat Kerja --}}
    <div class="col-lg-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white">

                <strong>Tingkat Tempat Kerja</strong>

            </div>

            <div class="card-body">

                <canvas id="tingkatTempatKerjaChart"></canvas>

            </div>

        </div>

    </div>

    {{-- Hubungan Bidang --}}
    <div class="col-lg-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white">

                <strong>Hubungan Bidang dengan Pekerjaan</strong>

            </div>

            <div class="card-body">

                <canvas id="hubunganBidangChart"></canvas>

            </div>

        </div>

    </div>

</div>

{{-- ==========================
    BAR CHART
========================== --}}

<div class="row g-4 mb-4">

    <div class="col-lg-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white">

                <strong>10 Kabupaten Terbanyak</strong>

            </div>

            <div class="card-body">

                <canvas id="kabupatenChart"></canvas>

            </div>

        </div>

    </div>

    <div class="col-lg-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white">

                <strong>10 Provinsi Terbanyak</strong>

            </div>

            <div class="card-body">

                <canvas id="provinsiChart"></canvas>

            </div>

        </div>

    </div>

</div>

{{-- ==========================
    TABLES
========================== --}}

<div class="row g-4">

    {{-- Top Perusahaan --}}
    <div class="col-lg-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white">

                <strong>Top 10 Perusahaan</strong>

            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0 summary-ranking-table">

                    <thead class="table-light">

                        <tr>

                            <th class="col-no">No</th>

                            <th>Perusahaan</th>

                            <th class="col-total">

                                Total

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($dashboard['tables']['perusahaan'] as $item)

                            <tr>

                                <td class="col-no">{{ $loop->iteration }}</td>

                                <td>{{ $item->nama_perusahaan }}</td>

                                <td class="col-total">

                                    <span class="badge bg-primary">

                                        {{ $item->total }}

                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="3" class="text-center text-muted py-4">

                                    Tidak ada data.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- Top Jabatan --}}
    <div class="col-lg-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white">

                <strong>Top 10 Jabatan</strong>

            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0 summary-ranking-table">

                    <thead class="table-light">

                        <tr>

                            <th class="col-no">No</th>

                            <th>Jabatan</th>

                            <th class="col-total">

                                Total

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($dashboard['tables']['jabatan'] as $item)

                            <tr>

                                <td class="col-no">{{ $loop->iteration }}</td>

                                <td>{{ $item->jabatan }}</td>

                                <td class="col-total">

                                    <span class="badge bg-success">

                                        {{ $item->total }}

                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="3" class="text-center text-muted py-4">

                                    Tidak ada data.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

{{-- BAGIAN 3 DIMULAI DARI SINI --}}
@push('scripts')

<script>

const chartColors = [
    '#0d6efd',
    '#198754',
    '#ffc107',
    '#dc3545',
    '#6f42c1',
    '#20c997',
    '#fd7e14',
    '#6610f2',
    '#0dcaf0',
    '#6c757d',
    '#1982c4',
    '#8ac926'
];

function createPieChart(canvasId, chartData) {

    const element = document.getElementById(canvasId);

    if (!element || !chartData || chartData.labels.length === 0) {
        return;
    }

    new Chart(element, {

        type: 'pie',

        data: {

            labels: chartData.labels,

            datasets: [{

                data: chartData.data,

                backgroundColor: chartColors,

                borderWidth: 1

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {

                    position: 'bottom'

                }

            }

        }

    });

}

function createHorizontalBarChart(canvasId, chartData) {

    const element = document.getElementById(canvasId);

    if (!element || !chartData || chartData.labels.length === 0) {
        return;
    }

    new Chart(element, {

        type: 'bar',

        data: {

            labels: chartData.labels,

            datasets: [{

                label: 'Jumlah Alumni',

                data: chartData.data,

                backgroundColor: '#0d6efd'

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            indexAxis: 'y',

            plugins: {

                legend: {

                    display: false

                }

            },

            scales: {

                x: {

                    beginAtZero: true,

                    ticks: {

                        precision: 0

                    }

                }

            }

        }

    });

}

/*
|--------------------------------------------------------------------------
| PIE CHART
|--------------------------------------------------------------------------
*/

createPieChart(
    'statusChart',
    @json($dashboard['charts']['status'])
);

createPieChart(
    'jenisPerusahaanChart',
    @json($dashboard['charts']['jenis_perusahaan'])
);

createPieChart(
    'tingkatTempatKerjaChart',
    @json($dashboard['charts']['tingkat_tempat_kerja'])
);

createPieChart(
    'hubunganBidangChart',
    @json($dashboard['charts']['hubungan_bidang'])
);

/*
|--------------------------------------------------------------------------
| BAR CHART
|--------------------------------------------------------------------------
*/

createHorizontalBarChart(
    'kabupatenChart',
    @json($dashboard['charts']['kabupaten'])
);

createHorizontalBarChart(
    'provinsiChart',
    @json($dashboard['charts']['provinsi'])
);

</script>

@endpush

@endsection
