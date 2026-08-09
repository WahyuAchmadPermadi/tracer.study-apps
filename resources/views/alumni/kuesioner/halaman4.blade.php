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
                Halaman 4 dari 8
            </p>

            <div class="progress mb-4">
                <div class="progress-bar bg-success" style="width:50%">
                    4 / 8
                </div>
            </div>

            <form method="POST"
                action="{{ route('kuesioner.halaman4.simpan') }}">

                @csrf

                {{-- Studi Lanjut --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Apakah Anda melanjutkan pendidikan setelah lulus?
                        <span class="text-danger">*</span>
                    </label>

                    @php
                        $studi = old('studi_lanjut', $jawaban->studi_lanjut);
                    @endphp

                    <div class="form-check">
                        <input class="form-check-input"
                            type="radio"
                            name="studi_lanjut"
                            value="Ya"
                            {{ $studi == 'Ya' ? 'checked' : '' }}
                            required>

                        <label class="form-check-label">
                            Ya
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input"
                            type="radio"
                            name="studi_lanjut"
                            value="Tidak"
                            {{ $studi == 'Tidak' ? 'checked' : '' }}>

                        <label class="form-check-label">
                            Tidak
                        </label>
                    </div>

                    @error('studi_lanjut')
                        <div class="text-danger small mt-2">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Sumber Biaya --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Sumber Pembiayaan Studi Lanjut
                    </label>

                    <input type="text"
                            class="form-control @error('sumber_biaya') is-invalid @enderror"
                            name="sumber_biaya"
                            value="{{ old('sumber_biaya', $jawaban->sumber_biaya) }}">

                    @error('sumber_biaya')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Nama PT --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Nama Perguruan Tinggi
                    </label>

                    <input type="text"
                            class="form-control @error('nama_pt') is-invalid @enderror"
                            name="nama_pt"
                            value="{{ old('nama_pt', $jawaban->nama_pt) }}">

                    @error('nama_pt')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Program Studi --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Program Studi
                    </label>

                    <input type="text"
                            class="form-control @error('program_studi_lanjut') is-invalid @enderror"
                            name="program_studi_lanjut"
                            value="{{ old('program_studi_lanjut', $jawaban->program_studi_lanjut) }}">

                    @error('program_studi_lanjut')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Tanggal Masuk --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Tanggal Masuk
                    </label>

                    <input type="month"
                            class="form-control @error('tanggal_masuk') is-invalid @enderror"
                            name="tanggal_masuk"
                            value="{{ old('tanggal_masuk', $jawaban->tanggal_masuk ? \Carbon\Carbon::parse($jawaban->tanggal_masuk)->format('Y-m') : '') }}">

                    @error('tanggal_masuk')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Hubungan Bidang --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Seberapa erat hubungan bidang studi dengan pekerjaan Anda saat ini?
                        <span class="text-danger">*</span>
                    </label>

                    <select class="form-select @error('hubungan_bidang') is-invalid @enderror"
                            name="hubungan_bidang"
                            required>

                        <option value="">-- Pilih --</option>

                        <option value="Sangat Erat"
                            {{ old('hubungan_bidang', $jawaban->hubungan_bidang) == 'Sangat Erat' ? 'selected' : '' }}>
                            Sangat Erat
                        </option>

                        <option value="Erat"
                            {{ old('hubungan_bidang', $jawaban->hubungan_bidang) == 'Erat' ? 'selected' : '' }}>
                            Erat
                        </option>

                        <option value="Cukup Erat"
                            {{ old('hubungan_bidang', $jawaban->hubungan_bidang) == 'Cukup Erat' ? 'selected' : '' }}>
                            Cukup Erat
                        </option>

                        <option value="Kurang Erat"
                            {{ old('hubungan_bidang', $jawaban->hubungan_bidang) == 'Kurang Erat' ? 'selected' : '' }}>
                            Kurang Erat
                        </option>

                        <option value="Tidak Sama Sekali"
                            {{ old('hubungan_bidang', $jawaban->hubungan_bidang) == 'Tidak Sama Sekali' ? 'selected' : '' }}>
                            Tidak Sama Sekali
                        </option>

                    </select>

                    @error('hubungan_bidang')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Tingkat Pendidikan --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Tingkat pendidikan apa yang paling tepat/sesuai untuk pekerjaan Anda saat ini?
                        <span class="text-danger">*</span>
                    </label>

                    <select class="form-select @error('tingkat_pendidikan') is-invalid @enderror"
                            name="tingkat_pendidikan"
                            required>

                        <option value="">-- Pilih --</option>

                        <option value="Setingkat lebih tinggi"
                            {{ old('tingkat_pendidikan', $jawaban->tingkat_pendidikan) == 'Setingkat lebih tinggi' ? 'selected' : '' }}>
                            Setingkat lebih tinggi
                        </option>

                        <option value="Tingkat yang sama"
                            {{ old('tingkat_pendidikan', $jawaban->tingkat_pendidikan) == 'Tingkat yang sama' ? 'selected' : '' }}>
                            Tingkat yang sama
                        </option>

                        <option value="Setingkat lebih rendah"
                            {{ old('tingkat_pendidikan', $jawaban->tingkat_pendidikan) == 'Setingkat lebih rendah' ? 'selected' : '' }}>
                            Setingkat lebih rendah
                        </option>

                        <option value="Tidak perlu pendidikan tinggi"
                            {{ old('tingkat_pendidikan', $jawaban->tingkat_pendidikan) == 'Tidak perlu pendidikan tinggi' ? 'selected' : '' }}>
                            Tidak perlu pendidikan tinggi
                        </option>

                    </select>

                    @error('tingkat_pendidikan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="d-flex justify-content-between questionnaire-navigation">

                    <a href="{{ route('kuesioner.halaman3') }}"
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
