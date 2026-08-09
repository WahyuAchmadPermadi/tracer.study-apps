@extends('layouts.app')

@section('title', 'Data Kuesioner')

@section('content')

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0 text-primary">
            <i class="bi bi-ui-checks-grid"></i>
            Data Pertanyaan Kuesioner
        </h5>

        <a href="{{ route('kuesioner.create') }}"
            class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i>
            Tambah Pertanyaan
        </a>

    </div>

    <div class="card-body">

        @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

        @endif

        <div class="table-responsive">

        <table class="table table-bordered table-hover align-middle">

            <thead class="table-primary">

                <tr>
                    <th>No</th>
                    <th>Urutan</th>
                    <th>Kategori</th>
                    <th>Pertanyaan</th>
                    <th>Jenis</th>
                    <th>Pilihan</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>
                </tr>

            </thead>

            <tbody>

                @forelse($kuesioners as $kuesioner)

                <tr>

                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kuesioner->urutan }}</td>
                    <td>{{ $kuesioner->kategori }}</td>

                    <td>{{ $kuesioner->pertanyaan }}</td>

                    <td>
                        @switch($kuesioner->jenis_jawaban)

                            @case('text')
                                <span class="badge bg-primary">Text</span>
                                @break

                            @case('textarea')
                                <span class="badge bg-dark">Textarea</span>
                                @break

                            @case('radio')
                                <span class="badge bg-success">Radio</span>
                                @break

                            @case('checkbox')
                                <span class="badge bg-warning text-dark">Checkbox</span>
                                @break

                            @case('select')
                                <span class="badge bg-info text-dark">Select</span>
                                @break

                            @case('number')
                                <span class="badge bg-secondary">Number</span>
                                @break
                        @endswitch
                    </td>

                    <td>
                        @if(is_array($kuesioner->pilihan) && count($kuesioner->pilihan))
                            <ul class="mb-0 ps-3">
                                @foreach($kuesioner->pilihan as $pilihan)
                                    <li>{{ $pilihan }}</li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>

                    <td>
                        @if($kuesioner->aktif)

                            <span class="badge bg-success">
                                Aktif
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Nonaktif
                            </span>

                        @endif

                    </td>

                    <td class="text-nowrap">

                        <a href="{{ route('kuesioner.edit', $kuesioner->id_kuesioner) }}"
                        class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>

                        <form action="{{ route('kuesioner.destroy', $kuesioner->id_kuesioner) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus pertanyaan ini?')">

                                <i class="bi bi-trash"></i> Hapus

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="8" class="text-center">
                        Belum ada data.
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>
        </div>
    </div>

</div>

@endsection