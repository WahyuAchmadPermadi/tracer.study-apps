@extends('layouts.app')

@section('title', 'Data Alumni')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
    <form action="{{ route('alumni.index') }}" method="GET" class="w-100" style="max-width: 420px;">
        <div class="input-group">
            <input type="search" name="search" value="{{ $search }}" class="form-control"
                placeholder="Cari NIM atau Nama Alumni..." aria-label="Cari NIM atau Nama Alumni">
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i>
                Cari
            </button>
        </div>
    </form>

    <div class="d-flex flex-wrap gap-2 justify-content-md-end">
        <a href="{{ route('alumni.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Tambah Alumni
        </a>

        <a href="{{ route('admin.import.index') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i>
            Import Excel
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped data-alumni-table">
        <thead class="table-dark">
            <tr>
                <th class="col-no">No</th>
                <th class="col-nim">NIM</th>
                <th class="col-nama">Nama</th>
                <th class="col-prodi">Program Studi</th>
                <th class="col-tahun">Tahun Lulus</th>
                <th class="col-email">Email</th>
                <th class="col-hp">No HP</th>
                <th class="col-aksi">Aksi</th>
            </tr>
        </thead>

        <tbody>

    @forelse($alumnis as $alumni)

        <tr>
            <td class="col-no">{{ $alumnis->firstItem() + $loop->index }}</td>
            <td class="col-nim">{{ $alumni->nim }}</td>
            <td class="col-nama">{{ $alumni->nama }}</td>
            <td class="col-prodi">{{ $alumni->kode_program_studi ? $alumni->kode_program_studi . ' - ' : '' }}{{ $alumni->program_studi }}</td>
            <td class="col-tahun">{{ $alumni->tahun_lulus }}</td>
            <td class="col-email">{{ $alumni->email }}</td>
            <td class="col-hp">{{ $alumni->no_hp }}</td>
            <td class="col-aksi">
                <a href="{{ route('alumni.edit', $alumni->nim) }}"
                    class="btn btn-sm btn-primary-subtle text-primary border-0 rounded-3"
                    title="Edit {{ $alumni->nama }}" aria-label="Edit {{ $alumni->nama }}">
                    <i class="bi bi-pencil-square"></i>
                </a>

                <form action="{{ route('alumni.destroy', $alumni->nim) }}"
                    method="POST"
                    class="d-inline">

                    @csrf
                    @method('DELETE')

                    <button
                        class="btn btn-sm btn-danger-subtle text-danger border-0 rounded-3"
                        title="Hapus {{ $alumni->nama }}" aria-label="Hapus {{ $alumni->nama }}"
                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                        <i class="bi bi-trash3"></i>
                    </button>

                </form>
            </td>
        </tr>

    @empty

        <tr>
            <td colspan="8" class="text-center">
                Belum ada data alumni.
            </td>
        </tr>

    @endforelse

        </tbody>

    </table>
</div>

{{ $alumnis->links() }}

@endsection
