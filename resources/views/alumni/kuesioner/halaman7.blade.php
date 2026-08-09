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
                Halaman 7 dari 8
            </p>

            <div class="progress mb-4">
                <div class="progress-bar bg-success" style="width:87.5%">
                    7 / 8
                </div>
            </div>

            <form method="POST"
                action="{{ route('kuesioner.halaman7.simpan') }}">

                @csrf

                {{-- Cara Mencari Kerja --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Melalui apa saja Anda mencari pekerjaan?
                        (boleh memilih lebih dari satu)
                    </label>

                    @php
                        $cara = [
                            'Iklan di koran/majalah',
                            'Internet / situs lowongan kerja',
                            'Media sosial',
                            'Bursa kerja kampus',
                            'Career Center Perguruan Tinggi',
                            'Relasi (teman/keluarga)',
                            'Dihubungi perusahaan',
                            'Membangun usaha sendiri',
                            'Lainnya'
                        ];

                        $caraDipilih = old('cara_mencari', $jawaban->cara_mencari ?? []);
                    @endphp

                    @foreach($cara as $item)

                        <div class="form-check">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="cara_mencari[]"
                                value="{{ $item }}"
                                {{ in_array($item, $caraDipilih) ? 'checked' : '' }}>

                            <label class="form-check-label">
                                {{ $item }}
                            </label>

                        </div>

                    @endforeach

                    @error('cara_mencari')
                        <div class="text-danger small mt-2">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Jumlah Lamaran --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Berapa banyak perusahaan/instansi yang Anda lamar?
                    </label>

                    <input
                        type="number"
                        class="form-control @error('jumlah_lamaran') is-invalid @enderror"
                        name="jumlah_lamaran"
                        min="0"
                        value="{{ old('jumlah_lamaran', $jawaban->jumlah_lamaran) }}">

                    @error('jumlah_lamaran')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Jumlah Respon --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Berapa banyak perusahaan/instansi yang merespon lamaran Anda?
                    </label>

                    <input
                        type="number"
                        class="form-control @error('jumlah_respon') is-invalid @enderror"
                        name="jumlah_respon"
                        min="0"
                        value="{{ old('jumlah_respon', $jawaban->jumlah_respon) }}">

                    @error('jumlah_respon')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Jumlah Wawancara --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Berapa banyak perusahaan/instansi yang mengundang Anda untuk wawancara?
                    </label>

                    <input
                        type="number"
                        class="form-control @error('jumlah_wawancara') is-invalid @enderror"
                        name="jumlah_wawancara"
                        min="0"
                        value="{{ old('jumlah_wawancara', $jawaban->jumlah_wawancara) }}">

                    @error('jumlah_wawancara')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Aktif Mencari --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Apakah Anda aktif mencari pekerjaan sebelum lulus?
                    </label>

                    @php
                        $aktif = old('aktif_mencari', $jawaban->aktif_mencari);
                    @endphp

                    <div class="form-check">

                        <input
                            class="form-check-input"
                            type="radio"
                            name="aktif_mencari"
                            value="Ya"
                            {{ $aktif == 'Ya' ? 'checked' : '' }}>

                        <label class="form-check-label">
                            Ya
                        </label>

                    </div>

                    <div class="form-check">

                        <input
                            class="form-check-input"
                            type="radio"
                            name="aktif_mencari"
                            value="Tidak"
                            {{ $aktif == 'Tidak' ? 'checked' : '' }}>

                        <label class="form-check-label">
                            Tidak
                        </label>

                    </div>

                    @error('aktif_mencari')
                        <div class="text-danger small mt-2">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Alasan --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Jika pekerjaan Anda tidak sesuai dengan bidang studi,
                        jelaskan alasannya.
                    </label>

                    <textarea
                        class="form-control @error('alasan') is-invalid @enderror"
                        name="alasan"
                        rows="4">{{ old('alasan', $jawaban->alasan) }}</textarea>

                    @error('alasan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="d-flex justify-content-between questionnaire-navigation">

                    <a href="{{ route('kuesioner.halaman6') }}"
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
