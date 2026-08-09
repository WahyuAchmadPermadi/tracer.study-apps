@extends('layouts.app')

@section('title', 'Edit Pertanyaan')

@section('content')

<h2 class="mb-4">Edit Pertanyaan Kuesioner</h2>

<form action="{{ route('kuesioner.update', $kuesioner->id_kuesioner) }}"
    method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Kategori</label>

        <input type="text"
                name="kategori"
                class="form-control"
                value="{{ old('kategori', $kuesioner->kategori) }}"
                required>
    </div>

    <div class="mb-3">
        <label class="form-label">Pertanyaan</label>

        <textarea name="pertanyaan"
                class="form-control"
                rows="3"
                required>{{ old('pertanyaan', $kuesioner->pertanyaan) }}</textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Jenis Jawaban</label>

        <select name="jenis_jawaban"
                class="form-select"
                required>

            @foreach(['text','textarea','radio','checkbox','select','number'] as $jenis)

                <option value="{{ $jenis }}"
                    {{ old('jenis_jawaban', $kuesioner->jenis_jawaban) == $jenis ? 'selected' : '' }}>

                    {{ ucfirst($jenis) }}

                </option>

            @endforeach

        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Pilihan Jawaban</label>

        <textarea name="pilihan"
                class="form-control"
                rows="5"
                placeholder="Satu pilihan setiap baris">{{ old('pilihan', is_array($kuesioner->pilihan) ? implode("\n", $kuesioner->pilihan) : '') }}</textarea>

        <small class="text-muted">
            Isi hanya jika jenis jawaban Radio, Checkbox, atau Select.
        </small>
    </div>

    <div class="mb-3">
        <label class="form-label">Urutan</label>

        <input type="number"
                name="urutan"
                class="form-control"
                value="{{ old('urutan', $kuesioner->urutan) }}">
        </div>

    <div class="form-check mb-3">

        <input type="checkbox"
                name="aktif"
                class="form-check-input"
                value="1"
                {{ old('aktif', $kuesioner->aktif) ? 'checked' : '' }}>

        <label class="form-check-label">
            Aktif
        </label>

    </div>

    <button class="btn btn-success">
        Update
    </button>

    <a href="{{ route('kuesioner.index') }}"
        class="btn btn-secondary">

        Kembali

    </a>

</form>

@endsection