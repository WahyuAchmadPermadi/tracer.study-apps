@extends('layouts.alumni')

@section('title','Tracer Study')

@section('content')

<div class="form-wrapper">

    <div class="card shadow-lg">

        <div class="card-body p-4">

            <h3 class="fw-bold mb-2">
                Tracer Study Alumni
            </h3>

            <p class="text-muted">
                Halaman 5 dari 8
            </p>

            <div class="progress mb-4">
                <div class="progress-bar bg-success" style="width:62.5%">
                    5 / 8
                </div>
            </div>

            <div class="alert alert-light border">

                <strong>Petunjuk:</strong><br>

                Nilailah tingkat kompetensi yang Anda miliki
                <b>saat lulus</b> dan tingkat kompetensi yang
                <b>dibutuhkan dalam pekerjaan</b> Anda saat ini.

                <div class="mt-3">
                    <strong>Skala Penilaian:</strong>

                    <div class="d-flex flex-wrap gap-2 mt-2">
                        <span class="border rounded bg-white px-2 py-1">1 = Sangat Tinggi</span>
                        <span class="border rounded bg-white px-2 py-1">2 = Tinggi</span>
                        <span class="border rounded bg-white px-2 py-1">3 = Cukup Tinggi</span>
                        <span class="border rounded bg-white px-2 py-1">4 = Rendah</span>
                        <span class="border rounded bg-white px-2 py-1">5 = Sangat Rendah</span>
                    </div>
                </div>

            </div>

            <form method="POST"
                action="{{ route('kuesioner.halaman5.simpan') }}">

                @csrf

                @php

                $kompetensi = [

                    [
                        'label' => 'Etika',
                        'lulus' => 'etika_lulus',
                        'kerja' => 'etika_kerja'
                    ],

                    [
                        'label' => 'Keahlian berdasarkan bidang ilmu',
                        'lulus' => 'keahlian_bidang_lulus',
                        'kerja' => 'keahlian_bidang_kerja'
                    ],

                    [
                        'label' => 'Bahasa Inggris',
                        'lulus' => 'bahasa_inggris_lulus',
                        'kerja' => 'bahasa_inggris_kerja'
                    ],

                    [
                        'label' => 'Penggunaan Teknologi Informasi',
                        'lulus' => 'teknologi_informasi_lulus',
                        'kerja' => 'teknologi_informasi_kerja'
                    ],

                    [
                        'label' => 'Komunikasi',
                        'lulus' => 'komunikasi_lulus',
                        'kerja' => 'komunikasi_kerja'
                    ],

                    [
                        'label' => 'Kerjasama Tim',
                        'lulus' => 'kerjasama_tim_lulus',
                        'kerja' => 'kerjasama_tim_kerja'
                    ],

                    [
                        'label' => 'Pengembangan Diri',
                        'lulus' => 'pengembangan_diri_lulus',
                        'kerja' => 'pengembangan_diri_kerja'
                    ],

                ];

                @endphp

                <div class="table-responsive questionnaire-scroll-table">

                    <table class="table table-bordered align-middle text-center questionnaire-rating-table questionnaire-competency-table">

                        <thead class="table-success questionnaire-header">

                            <tr>

                                <th rowspan="2" class="questionnaire-header-label">
                                    Kompetensi
                                </th>

                                <th colspan="5">
                                    Saat Lulus
                                </th>

                                <th colspan="5">
                                    Dibutuhkan Dalam Pekerjaan
                                </th>

                            </tr>

                            <tr>

                                <th>1</th>
                                <th>2</th>
                                <th>3</th>
                                <th>4</th>
                                <th>5</th>

                                <th>1</th>
                                <th>2</th>
                                <th>3</th>
                                <th>4</th>
                                <th>5</th>

                            </tr>

                        </thead>

                        <tbody>

                        @foreach($kompetensi as $k)

                        <tr>

                            <td class="text-start questionnaire-mobile-label">
                                {{ $k['label'] }}
                            </td>

                            @for($i=1;$i<=5;$i++)

                            <td>

                                <input
                                    type="radio"
                                    name="{{ $k['lulus'] }}"
                                    value="{{ $i }}"
                                    {{ old($k['lulus'], $jawaban->{$k['lulus']}) == $i ? 'checked' : '' }}
                                    required>

                            </td>

                            @endfor

                            @for($i=1;$i<=5;$i++)

                            <td>

                                <input
                                    type="radio"
                                    name="{{ $k['kerja'] }}"
                                    value="{{ $i }}"
                                    {{ old($k['kerja'], $jawaban->{$k['kerja']}) == $i ? 'checked' : '' }}
                                    required>

                            </td>

                            @endfor

                        </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        Mohon lengkapi seluruh penilaian kompetensi.
                    </div>
                @endif

                <div class="d-flex justify-content-between mt-4 questionnaire-navigation">

                    <a href="{{ route('kuesioner.halaman4') }}"
                        class="btn btn-secondary">

                        ← Sebelumnya

                    </a>

                    <button type="submit"
                            class="btn btn-success">

                        Selanjutnya →

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
