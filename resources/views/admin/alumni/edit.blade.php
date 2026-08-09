@extends('layouts.app')

@section('title', 'Edit Alumni')

@section('content')

<h2 class="mb-4">Edit Alumni</h2>

<form method="POST" action="{{ url('/admin/alumni/'.$alumni->nim) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>NIM</label>
        <input
            type="text"
            name="nim"
            class="form-control"
            value="{{ $alumni->nim }}"
            readonly
        >
    </div>

    <div class="mb-3">
        <label>Nama</label>
        <input
            type="text"
            name="nama"
            class="form-control"
            value="{{ $alumni->nama }}"
        >
    </div>

    <div class="mb-3">
        <label>Tanggal Lahir</label>
        <input
            type="date"
            name="tanggal_lahir"
            class="form-control"
            value="{{ $alumni->tanggal_lahir }}"
        >
    </div>

    <div class="mb-3">
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

    <div class="mb-3 col-md-3 px-0">
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

    <div class="mb-3">
        <label>Email</label>
        <input
            type="email"
            name="email"
            class="form-control"
            value="{{ $alumni->email }}"
        >
    </div>

    <div class="mb-3">
        <label>No HP</label>
        <input
            type="text"
            name="no_hp"
            class="form-control"
            value="{{ $alumni->no_hp }}"
        >
    </div>

    <button class="btn btn-primary">
        Update
    </button>

    <a href="{{ url('/admin/alumni') }}" class="btn btn-secondary">
        Kembali
    </a>

</form>

@endsection
