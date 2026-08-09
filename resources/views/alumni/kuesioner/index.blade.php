@extends('layouts.alumni')

@section('title', 'Kuesioner Tracer Study')

@section('content')

<div class="form-wrapper">

    <div class="card shadow-lg">

        <div class="card-header bg-primary text-white py-4">

            <h2 class="mb-0 fw-bold">

                <i class="bi bi-ui-checks-grid me-2"></i>

                Kuesioner Tracer Study

            </h2>

        </div>

        <div class="card-body p-4">

            <form method="POST"
                action="{{ route('alumni.kuesioner.store') }}">

                @csrf

                @foreach($kuesioners as $item)

                    <div class="mb-5">

                        <label class="form-label fw-bold fs-5">

                            {{ $item->urutan }}.
                            {{ $item->pertanyaan }}

                        </label>

                        @php
                            $pilihan = $item->pilihan ?? [];
                        @endphp

                        @if($item->jenis_jawaban == 'text')

                            <input
                                type="text"
                                name="jawaban[{{ $item->id_kuesioner }}]"
                                class="form-control form-control-lg">

                        @elseif($item->jenis_jawaban == 'textarea')

                            <textarea
                                rows="4"
                                class="form-control form-control-lg"
                                name="jawaban[{{ $item->id_kuesioner }}]"></textarea>

                        @elseif($item->jenis_jawaban == 'number')

                            <input
                                type="number"
                                class="form-control form-control-lg"
                                name="jawaban[{{ $item->id_kuesioner }}]">

                        @elseif($item->jenis_jawaban == 'radio')

                            @foreach($pilihan as $opsi)

                                <div class="form-check mb-2">

                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="jawaban[{{ $item->id_kuesioner }}]"
                                        value="{{ $opsi }}">

                                    <label class="form-check-label">

                                        {{ $opsi }}

                                    </label>

                                </div>

                            @endforeach

                        @elseif($item->jenis_jawaban == 'checkbox')

                            @foreach($pilihan as $opsi)

                                <div class="form-check mb-2">

                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="jawaban[{{ $item->id_kuesioner }}][]"
                                        value="{{ $opsi }}">

                                    <label class="form-check-label">

                                        {{ $opsi }}

                                    </label>

                                </div>

                            @endforeach

                        @elseif($item->jenis_jawaban == 'select')

                            <select
                                class="form-select form-select-lg"
                                name="jawaban[{{ $item->id_kuesioner }}]">

                                <option value="">-- Pilih --</option>

                                @foreach($pilihan as $opsi)

                                    <option value="{{ $opsi }}">

                                        {{ $opsi }}

                                    </option>

                                @endforeach

                            </select>

                        @endif

                    </div>

                @endforeach

                <div class="d-grid mt-4">

                    <button class="btn btn-primary btn-lg">

                        <i class="bi bi-check-circle me-2"></i>

                        Simpan Kuesioner

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection