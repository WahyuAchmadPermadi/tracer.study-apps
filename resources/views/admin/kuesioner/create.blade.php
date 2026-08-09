@extends('layouts.app')

@section('title','Tambah Pertanyaan')

@section('content')

<h2 class="mb-4">
    Tambah Pertanyaan Kuesioner
</h2>

<form action="{{ route('kuesioner.store') }}"
    method="POST">

@csrf

<div class="mb-3">

    <label class="form-label">
        Kategori
    </label>

    <input type="text"
        name="kategori"
        class="form-control"
        value="{{ old('kategori') }}"
        required>

</div>

<div class="mb-3">

    <label class="form-label">
        Pertanyaan
    </label>

    <textarea
        name="pertanyaan"
        class="form-control"
        rows="3"
        required>{{ old('pertanyaan') }}</textarea>

</div>

<div class="mb-3">

    <label class="form-label">
        Jenis Jawaban
    </label>

    <select
        name="jenis_jawaban"
        class="form-select"
        required>
        <option value="">-- Pilih --</option>
        <option value="text">Text</option>
        <option value="textarea">Textarea</option>
        <option value="radio">Radio</option>
        <option value="checkbox">Checkbox</option>
        <option value="select">Select</option>
        <option value="number">Number</option>

    </select>

</div>

<div class="mb-3">

    <label class="form-label">
        Pilihan Jawaban
    </label>

    <textarea
        name="pilihan"
        class="form-control"
        rows="5"
        placeholder="Satu pilihan setiap baris"></textarea>

    <small class="text-muted">
        Isi hanya jika jenis jawaban Radio, Checkbox, atau Select.
    </small>

</div>

<div class="mb-3">

    <label class="form-label">
        Urutan
    </label>

    <input
        type="number"
        name="urutan"
        class="form-control"
        value="1">

</div>

<div class="form-check mb-3">

    <input
        type="checkbox"
        class="form-check-input"
        name="aktif"
        checked>

    <label class="form-check-label">
        Aktif
    </label>

</div>

<button class="btn btn-success">
    Simpan
</button>

<a href="{{ route('kuesioner.index') }}"
    class="btn btn-secondary">

    Kembali

</a>

</form>

@endsection