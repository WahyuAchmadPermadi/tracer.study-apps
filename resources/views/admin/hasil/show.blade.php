@extends('layouts.app')

@section('content')

<div class="card shadow">

    <div class="card-header bg-success text-white">

        <h4>

            Detail Hasil Kuesioner

        </h4>

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>

                <th width="200">NIM</th>

                <td>{{ $respon->nim }}</td>

            </tr>

            <tr>

                <th>Nama</th>

                <td>{{ $respon->alumni->nama }}</td>

            </tr>

            <tr>

                <th>Program Studi</th>

                <td>{{ $respon->alumni->program_studi }}</td>

            </tr>

            <tr>

                <th>Tahun Lulus</th>

                <td>{{ $respon->alumni->tahun_lulus }}</td>

            </tr>

        </table>

        <hr>

        @foreach($jawaban as $item)

            <div class="mb-4">

                <label class="fw-bold">

                    {{ $item->kuesioner->urutan }}.

                    {{ $item->kuesioner->pertanyaan }}

                </label>

                @php

                    $nilai = $item->jawaban;

                @endphp

                @if($item->kuesioner->jenis_jawaban == 'checkbox')

                    @php

                        $decoded = json_decode($nilai,true);

                    @endphp

                    <ul>

                        @foreach($decoded as $opsi)

                            <li>{{ $opsi }}</li>

                        @endforeach

                    </ul>

                @else

                    <div class="form-control bg-light">

                        {{ $nilai }}

                    </div>

                @endif

            </div>

        @endforeach

        <a href="{{ route('hasil.index') }}"

            class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>

            Kembali

        </a>

    </div>

</div>

@endsection