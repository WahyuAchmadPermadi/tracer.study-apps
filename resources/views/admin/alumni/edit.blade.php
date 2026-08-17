@extends('layouts.app')

@section('title', 'Edit Alumni')

@section('content')

<h2 class="mb-4">Edit Alumni</h2>

<form method="POST" action="{{ url('/admin/alumni/'.$alumni->nim) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-12 col-md-4 mb-3">
            <label>NIM</label>
            <input
                type="text"
                name="nim"
                class="form-control"
                value="{{ $alumni->nim }}"
                readonly
            >
        </div>

        <div class="col-12 col-md-8 mb-3">
            <label>Nama</label>
            <input
                type="text"
                name="nama"
                class="form-control"
                value="{{ $alumni->nama }}"
            >
        </div>

        <div class="col-12 col-md-3 mb-3">
            <label>Tanggal Lahir</label>
            <input
                type="date"
                name="tanggal_lahir"
                class="form-control"
                value="{{ $alumni->tanggal_lahir }}"
            >
        </div>

        <div class="col-12 col-md-6 mb-3">
            <label>Program Studi</label>
            @php($kodeProgramStudi = old('kode_program_studi', $alumni->kode_program_studi ?: \App\Models\Alumni::kodeProgramStudiDariNama($alumni->program_studi)))
            <select name="kode_program_studi" class="form-select @error('kode_program_studi') is-invalid @enderror">
                <option value="">-- Pilih Program Studi --</option>
                @foreach($programStudis as $kode => $nama)
                    <option value="{{ $kode }}" @selected($kodeProgramStudi === $kode)>
                        {{ $kode }} - {{ $nama }}
                    </option>
                @endforeach
            </select>
            @error('kode_program_studi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="w-100"></div>

        <div class="col-12 col-md-3 mb-3">
            <label>Tahun Lulus</label>
            <input
                type="number"
                name="tahun_lulus"
                class="form-control"
                min="1900"
                max="9999"
                value="{{ $alumni->tahun_lulus }}"
            >
        </div>

        <div class="col-12 col-md-6 mb-3">
            <label>Email</label>
            <input
                type="email"
                name="email"
                class="form-control"
                value="{{ $alumni->email }}"
            >
        </div>

        <div class="w-100"></div>

        <div class="col-12 col-md-5 mb-3">
            <label for="no_hp">No HP</label>
            <div class="input-group">
                <span class="input-group-text">+62</span>
                <input
                    type="text"
                    id="no_hp"
                    name="no_hp"
                    class="form-control @error('no_hp') is-invalid @enderror"
                    value="{{ old('no_hp', \App\Models\Alumni::noHpUntukInput($alumni->no_hp)) }}"
                    inputmode="numeric"
                    pattern="[0-9]*"
                    maxlength="13"
                    placeholder="81234567890"
                    oninput="this.value = this.value.replace(/\D/g, '')"
                    required>
            </div>
            <div class="form-text">Masukkan nomor tanpa 0 di depan. Contoh: 81234567890</div>
            @error('no_hp')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <button class="btn btn-primary">
        Update
    </button>

    <a href="{{ url('/admin/alumni') }}" class="btn btn-secondary">
        Kembali
    </a>

</form>

@endsection
