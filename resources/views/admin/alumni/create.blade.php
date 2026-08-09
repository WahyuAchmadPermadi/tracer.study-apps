@extends('layouts.app')

@section('title', 'Tambah Alumni')

@section('content')

<h2 class="mb-4">Tambah Alumni</h2>

<form method="POST" action="{{ url('/admin/alumni') }}">
    @csrf

    <div class="mb-3">
        <label>NIM</label>
        <input type="text" name="nim" class="form-control">
    </div>

    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control">
    </div>

    <div class="mb-3">
        <label>Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" class="form-control">
    </div>

    <div class="mb-3">
        <label>Program Studi</label>
        <select name="kode_program_studi" class="form-select @error('kode_program_studi') is-invalid @enderror">
            <option value="">-- Pilih Program Studi --</option>
            @foreach($programStudis as $kode => $nama)
                <option value="{{ $kode }}" @selected(old('kode_program_studi') === $kode)>
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
        <input type="number" name="tahun_lulus" class="form-control" min="1900" max="9999" placeholder="2026" value="{{ old('tahun_lulus') }}">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>

    <div class="mb-3">
        <label>No HP</label>
        <input type="text" name="no_hp" class="form-control">
    </div>

    <button class="btn btn-success">
        Simpan
    </button>

    <a href="{{ url('/admin/alumni') }}"
        class="btn btn-secondary">
        Kembali
    </a>

</form>

@endsection
