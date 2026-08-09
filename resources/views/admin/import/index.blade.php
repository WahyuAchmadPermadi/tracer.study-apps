@extends('layouts.app')

@section('title','Import Data Alumni')

@section('content')

<h2 class="mb-4">Import Data Alumni</h2>
<div class="mb-3">
    <a href="{{ route('admin.import.template') }}"
        class="btn btn-success">

        📥 Download Template Excel

    </a>
</div>
<div class="alert alert-info">
    <strong>Petunjuk Import</strong>
    <ol class="mb-0 mt-2">
        <li>Download template Excel.</li>
        <li>Isi data alumni sesuai format.</li>
        <li>Jangan mengubah nama kolom.</li>
        <li>Simpan file dalam format <strong>.xlsx</strong>.</li>
        <li>Upload kembali melalui form di bawah.</li>
    </ol>
</div>
@if(session('success'))

<div class="alert alert-success">
    <h5>{{ session('success') }}</h5>
    <hr>
    <p>✅ Data Baru : <strong>{{ session('inserted') }}</strong></p>
    <p>🔄 Data Update : <strong>{{ session('updated') }}</strong></p>
    <p>⚠ Dilewati : <strong>{{ session('skipped') }}</strong></p>
    <p>❌ Gagal : <strong>{{ session('failed') }}</strong></p>
</div>

@endif

@if(session('errors') && count(session('errors')))

<div class="card mt-3">

    <div class="card-header bg-danger text-white">

        Detail Error Import

    </div>

    <div class="card-body">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Baris</th>
                    <th>NIM</th>
                    <th>Keterangan</th>
                </tr>
            </thead>

            <tbody>
            @foreach(session('errors') as $error)
                <tr>
                    <td>{{ $error['baris'] }}</td>
                    <td>{{ $error['nim'] }}</td>
                    <td>{{ $error['pesan'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@endif

<div class="card">
    <div class="card-header">
        Upload File Excel
    </div>

    <div class="card-body">

        <form action="{{ route('admin.import') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="mb-3">
                <label class="form-label">
                    File Excel
                </label>

                <input
                    type="file"
                    name="file"
                    class="form-control"
                    required>
            </div>

            <button class="btn btn-success">
                Import Excel
            </button>

        </form>

    </div>
</div>

@endsection