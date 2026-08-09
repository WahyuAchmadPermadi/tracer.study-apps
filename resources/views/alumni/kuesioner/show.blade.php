@extends('layouts.alumni')

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-6 col-md-8">

        <div class="card shadow-lg border-0 rounded-4">

            <div class="card-header bg-success text-white text-center py-4 rounded-top-4">

                <h2 class="mb-0">
                    <i class="bi bi-eye"></i>
                    Hasil Kuesioner
                </h2>

            </div>

            <div class="card-body p-4">

                @foreach($jawaban as $item)

                    <div class="mb-4">

                        <label class="fw-bold mb-2">

                            {{ $item->kuesioner->urutan }}.
                            {{ $item->kuesioner->pertanyaan }}

                        </label>

                        @php
                            $nilai = $item->jawaban;
                        @endphp

                        @if($item->kuesioner->jenis_jawaban == 'checkbox')

                            @php
                                $decoded = json_decode($nilai, true);
                            @endphp

                            <div class="form-control bg-light">

                                @foreach($decoded as $opsi)

                                    ✔ {{ $opsi }}<br>

                                @endforeach

                            </div>

                        @else

                            <div class="form-control bg-light">

                                {{ $nilai }}

                            </div>

                        @endif

                    </div>

                @endforeach

                <div class="text-center mt-4">

                    <a href="{{ route('alumni.dashboard') }}"
                        class="btn btn-secondary px-4">

                        <i class="bi bi-arrow-left"></i>
                        Kembali

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection