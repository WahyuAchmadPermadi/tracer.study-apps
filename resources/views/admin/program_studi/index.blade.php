@extends('layouts.app')

@section('title', 'Program Studi')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Master Program Studi</h5>
        <a href="{{ route('program-studi.create') }}" class="btn btn-light btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Program Studi
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr><th class="text-center">No</th><th>Kode Program Studi</th><th>Nama Program Studi</th><th>Status</th><th class="text-center">Aksi</th></tr>
                </thead>
                <tbody>
                @forelse($programStudis as $programStudi)
                    <tr>
                        <td class="text-center">{{ $programStudis->firstItem() + $loop->index }}</td>
                        <td>{{ $programStudi->kode_program_studi }}</td>
                        <td>{{ $programStudi->nama_program_studi }}</td>
                        <td><span class="badge {{ $programStudi->status === 'Aktif' ? 'bg-success' : 'bg-secondary' }}">{{ $programStudi->status }}</span></td>
                        <td class="text-center text-nowrap">
                            <a href="{{ route('program-studi.edit', $programStudi) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                            <form action="{{ route('program-studi.toggle', $programStudi) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-outline-secondary btn-sm">{{ $programStudi->status === 'Aktif' ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada program studi.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $programStudis->links() }}</div>
    </div>
</div>
@endsection
