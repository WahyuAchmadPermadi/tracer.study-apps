@extends('layouts.app')

@section('title', 'Detail Hasil Tracer Study')

@section('content')

<div class="mb-4">

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h2 class="fw-bold mb-1">
                Detail Hasil Tracer Study
            </h2>

            <p class="text-muted mb-0">
                Informasi hasil pengisian tracer study alumni
            </p>
        </div>

        <a href="{{ route('admin.jawaban-tracer.index') }}"
            class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>
            Kembali

        </a>

    </div>

</div>


{{-- ========================================================= --}}
{{-- DATA ALUMNI --}}
{{-- ========================================================= --}}

<div class="card mb-4">

    <div class="card-header bg-success text-white">

        <h5 class="mb-0">
            <i class="bi bi-person-fill"></i>
            Data Alumni
        </h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="text-muted">NIM</label>

                <div class="fw-semibold">
                    {{ $jawaban->nim ?? '-' }}
                </div>
            </div>


            <div class="col-md-6 mb-3">
                <label class="text-muted">Nama Alumni</label>

                <div class="fw-semibold">
                    {{ $jawaban->alumni->nama ?? '-' }}
                </div>
            </div>


            <div class="col-md-6 mb-3">
                <label class="text-muted">Program Studi</label>

                <div class="fw-semibold">
                    {{ $jawaban->alumni->program_studi ?? '-' }}
                </div>
            </div>


            <div class="col-md-6 mb-3">
                <label class="text-muted">Tahun Lulus</label>

                <div class="fw-semibold">
                    {{ $jawaban->alumni->tahun_lulus ?? '-' }}
                </div>
            </div>


            <div class="col-md-6 mb-3">
                <label class="text-muted">WhatsApp</label>

                <div class="fw-semibold">
                    {{ $jawaban->whatsapp ?? '-' }}
                </div>
            </div>


            <div class="col-md-6 mb-3">
                <label class="text-muted">NIK</label>

                <div class="fw-semibold">
                    {{ $jawaban->nik ?? '-' }}
                </div>
            </div>


            <div class="col-md-6 mb-3">
                <label class="text-muted">NPWP</label>

                <div class="fw-semibold">
                    {{ $jawaban->npwp ?? '-' }}
                </div>
            </div>


            <div class="col-md-6 mb-3">
                <label class="text-muted">Status Saat Ini</label>

                <div>
                    <span class="badge bg-success">
                        {{ $jawaban->status ?? '-' }}
                    </span>
                </div>
            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- INFORMASI PEKERJAAN --}}
{{-- ========================================================= --}}

<div class="card mb-4">

    <div class="card-header">

        <h5 class="mb-0">
            <i class="bi bi-briefcase-fill text-success"></i>
            Informasi Pekerjaan
        </h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="text-muted">
                    Mulai Mencari Kerja
                </label>

                <div class="fw-semibold">
                    {{ $jawaban->mulai_mencari_kerja ?? '-' }}
                </div>
            </div>


            <div class="col-md-6 mb-3">
                <label class="text-muted">
                    Pekerjaan Pertama
                </label>

                <div class="fw-semibold">
                    {{ $jawaban->pekerjaan_pertama ?? '-' }}
                </div>
            </div>


            <div class="col-md-6 mb-3">
                <label class="text-muted">
                    Pendapatan
                </label>

                <div class="fw-semibold">

                    @if(!empty($jawaban->pendapatan))

                        Rp {{ number_format(
                            $jawaban->pendapatan,
                            0,
                            ',',
                            '.'
                        ) }}

                    @else

                        -

                    @endif

                </div>
            </div>


            <div class="col-md-6 mb-3">
                <label class="text-muted">
                    Jenis Perusahaan
                </label>

                <div class="fw-semibold">
                    {{ $jawaban->jenis_perusahaan ?? '-' }}
                </div>
            </div>


            <div class="col-md-6 mb-3">
                <label class="text-muted">
                    Nama Perusahaan / Instansi
                </label>

                <div class="fw-semibold">
                    {{ $jawaban->nama_perusahaan ?? '-' }}
                </div>
            </div>


            <div class="col-md-6 mb-3">
                <label class="text-muted">
                    Jabatan
                </label>

                <div class="fw-semibold">
                    {{ $jawaban->jabatan ?? '-' }}
                </div>
            </div>


            <div class="col-md-6 mb-3">
                <label class="text-muted">
                    Provinsi Tempat Kerja
                </label>

                <div class="fw-semibold">
                    {{ $jawaban->provinsi ?? '-' }}
                </div>
            </div>


            <div class="col-md-6 mb-3">
                <label class="text-muted">
                    Kabupaten/Kota
                </label>

                <div class="fw-semibold">
                    {{ $jawaban->kabupaten ?? '-' }}
                </div>
            </div>


            <div class="col-md-6 mb-3">
                <label class="text-muted">
                    Tingkat Tempat Kerja
                </label>

                <div class="fw-semibold">
                    {{ $jawaban->tingkat_tempat_kerja ?? '-' }}
                </div>
            </div>


            <div class="col-md-6 mb-3">
                <label class="text-muted">
                    Hubungan Bidang Studi dengan Pekerjaan
                </label>

                <div class="fw-semibold">
                    {{ $jawaban->hubungan_bidang ?? '-' }}
                </div>
            </div>


            <div class="col-md-6 mb-3">
                <label class="text-muted">
                    Tingkat Pendidikan yang Sesuai
                </label>

                <div class="fw-semibold">
                    {{ $jawaban->tingkat_pendidikan ?? '-' }}
                </div>
            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- STUDI LANJUT --}}
{{-- ========================================================= --}}

<div class="card mb-4">

    <div class="card-header">

        <h5 class="mb-0">
            <i class="bi bi-mortarboard-fill text-success"></i>
            Studi Lanjut
        </h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Studi Lanjut
                </label>

                <div class="fw-semibold">
                    {{ $jawaban->studi_lanjut ?? '-' }}
                </div>

            </div>


            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Sumber Biaya
                </label>

                <div class="fw-semibold">
                    {{ $jawaban->sumber_biaya ?? '-' }}
                </div>

            </div>


            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Perguruan Tinggi
                </label>

                <div class="fw-semibold">
                    {{ $jawaban->nama_pt ?? '-' }}
                </div>

            </div>


            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Program Studi Lanjut
                </label>

                <div class="fw-semibold">
                    {{ $jawaban->program_studi_lanjut ?? '-' }}
                </div>

            </div>


            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Tanggal Masuk
                </label>

                <div class="fw-semibold">
                    {{ $jawaban->tanggal_masuk ?? '-' }}
                </div>

            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- KOMPETENSI --}}
{{-- ========================================================= --}}

<div class="card mb-4">

    <div class="card-header">

        <h5 class="mb-0">
            <i class="bi bi-bar-chart-fill text-success"></i>
            Kompetensi Alumni
        </h5>

    </div>

    <div class="card-body">

        @php
            $skalaKompetensi = [
                1 => 'Sangat Tinggi (1)',
                2 => 'Tinggi (2)',
                3 => 'Cukup Tinggi (3)',
                4 => 'Rendah (4)',
                5 => 'Sangat Rendah (5)',
            ];

            $kompetensi = [
                ['label' => 'Etika', 'lulus' => 'etika_lulus', 'kerja' => 'etika_kerja'],
                ['label' => 'Keahlian Berdasarkan Bidang Ilmu', 'lulus' => 'keahlian_bidang_lulus', 'kerja' => 'keahlian_bidang_kerja'],
                ['label' => 'Bahasa Inggris', 'lulus' => 'bahasa_inggris_lulus', 'kerja' => 'bahasa_inggris_kerja'],
                ['label' => 'Penggunaan Teknologi Informasi', 'lulus' => 'teknologi_informasi_lulus', 'kerja' => 'teknologi_informasi_kerja'],
                ['label' => 'Komunikasi', 'lulus' => 'komunikasi_lulus', 'kerja' => 'komunikasi_kerja'],
                ['label' => 'Kerja Sama Tim', 'lulus' => 'kerjasama_tim_lulus', 'kerja' => 'kerjasama_tim_kerja'],
                ['label' => 'Pengembangan Diri', 'lulus' => 'pengembangan_diri_lulus', 'kerja' => 'pengembangan_diri_kerja'],
            ];

            $formatNilaiKompetensi = function ($nilai) use ($skalaKompetensi) {
                if ($nilai === null || $nilai === '' || !array_key_exists((int) $nilai, $skalaKompetensi)) {
                    return '-';
                }

                return $skalaKompetensi[(int) $nilai];
            };
        @endphp

        <div class="table-responsive">

            <table class="table table-bordered mb-0">

                <thead class="table-light">

                    <tr>
                        <th style="width: 42%;">Kompetensi</th>
                        <th style="width: 29%;">Saat Lulus</th>
                        <th style="width: 29%;">Saat Bekerja</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($kompetensi as $item)
                        <tr>
                            <td>{{ $item['label'] }}</td>
                            <td>{{ $formatNilaiKompetensi($jawaban->{$item['lulus']}) }}</td>
                            <td>{{ $formatNilaiKompetensi($jawaban->{$item['kerja']}) }}</td>
                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>


<div class="text-end mb-4">

    <a href="{{ route('admin.jawaban-tracer.index') }}"
        class="btn btn-secondary">

        <i class="bi bi-arrow-left"></i>
        Kembali ke Daftar

    </a>

</div>

@endsection
