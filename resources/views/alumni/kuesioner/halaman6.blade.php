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
                Halaman 6 dari 8
            </p>
            <div class="progress mb-4">
                <div class="progress-bar bg-success"
                    style="width:75%">
                    6 / 8
                </div>
            </div>
            <div class="alert alert-light border">
                <strong>Petunjuk :</strong><br>
                Menurut Anda, seberapa besar penekanan pada metode pembelajaran
                berikut di program studi Anda?
            </div>
            <form method="POST"
                action="{{ route('kuesioner.halaman6.simpan') }}">
                @csrf
                @php
                $metode = [
                    [
                        'label' => 'Perkuliahan',
                        'field' => 'perkuliahan'
                    ],
                    [
                        'label' => 'Demonstrasi',
                        'field' => 'demonstrasi'
                    ],
                    [
                        'label' => 'Partisipasi dalam proyek riset',
                        'field' => 'proyek_riset'
                    ],
                    [
                        'label' => 'Magang',
                        'field' => 'magang'
                    ],
                    [
                        'label' => 'Praktikum',
                        'field' => 'praktikum'
                    ],
                    [
                        'label' => 'Kerja Lapangan',
                        'field' => 'kerja_lapangan'
                    ],
                    [
                        'label' => 'Diskusi',
                        'field' => 'diskusi'
                    ],
                ];
                @endphp
                <div class="table-responsive questionnaire-scroll-table">
                    <table class="table table-bordered text-center align-middle questionnaire-rating-table questionnaire-methods-table">
                        <thead class="table-success questionnaire-header">
                            <tr>
                                <th class="questionnaire-header-label">
                                    Metode Pembelajaran
                                </th>
                                <th>Sangat Kecil</th>
                                <th>Kecil</th>
                                <th>Sedang</th>
                                <th>Besar</th>
                                <th>Sangat Besar</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($metode as $m)
                        <tr>
                            <td class="text-start questionnaire-mobile-label">
                                {{ $m['label'] }}
                            </td>
                            @for($i=1;$i<=5;$i++)
                            <td>
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="{{ $m['field'] }}"
                                    value="{{ $i }}"
                                    {{ old($m['field'], $jawaban->{$m['field']}) == $i ? 'checked' : '' }}
                                    required>
                            </td>
                            @endfor
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @if($errors->any())
                    <div class="alert alert-danger mt-3">
                        Mohon lengkapi seluruh penilaian metode pembelajaran.
                    </div>
                @endif
                <div class="d-flex justify-content-between mt-4 questionnaire-navigation">
                    <a href="{{ route('kuesioner.halaman5') }}"
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
