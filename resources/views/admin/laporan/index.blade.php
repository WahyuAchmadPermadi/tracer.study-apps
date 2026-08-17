@extends('layouts.app')

@section('title','Laporan Tracer Study')

@section('content')

<div class="card shadow">

    <div class="card-header bg-primary text-white">

        <h4 class="mb-0">
            <i class="bi bi-file-earmark-bar-graph"></i>
            Laporan Tracer Study
        </h4>

    </div>

    <div class="card-body">

        <form action="{{ route('laporan.filter') }}" method="POST">
        @csrf

            <div class="row align-items-end">

                <div class="col-md-3">
                    <label>Periode Tracer Study</label>
                    <select name="id_periode" class="form-select">
                        <option value="">Semua Periode</option>
                        @foreach($periode as $item)
                            <option value="{{ $item->id_periode }}" @selected((string) request('id_periode') === (string) $item->id_periode)>{{ $item->tahun }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Tahun Lulus</label>
                    <select name="tahun_lulus" class="form-select">
                        <option value="">Semua</option>
                        @foreach($tahun as $item)
                        <option value="{{ $item }}"
                            {{ request('tahun_lulus') == $item ? 'selected' : '' }}>
                            {{ $item }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Program Studi</label>
                    <select name="program_studi" class="form-select">
                        <option value="">Semua</option>
                        @foreach($prodi as $item)
                        <option value="{{ $item }}"
                            {{ request('program_studi') == $item ? 'selected' : '' }}>
                            {{ $item }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>

                        <option value="sudah"
                            {{ request('status') == 'sudah' ? 'selected' : '' }}>
                            Sudah Mengisi
                        </option>
                        <option value="belum"
                            {{ request('status') == 'belum' ? 'selected' : '' }}>
                            Belum Mengisi
                        </option>
                    </select>
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Tampilkan
                    </button>
                </div>

            </div>
        </form>

        <hr>

        <table class="table table-bordered">

            <thead class="table-dark">

                <tr>

                    <th>No</th>

                    <th>NIM</th>

                    <th>Nama</th>

                    <th>Program Studi</th>

                    <th>Tahun Lulus</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

            @if(isset($laporan) && $laporan->count())

            @foreach($laporan as $item)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $item->nim }}</td>

                <td>{{ $item->nama }}</td>

                <td>{{ $item->program_studi }}</td>

                <td>{{ $item->tahun_lulus }}</td>

                <td>

                    @if($item->jawabanTracer && $item->jawabanTracer->submitted_at)

                        <span class="badge bg-success">
                            Sudah Mengisi
                        </span>

                    @else

                        <span class="badge bg-danger">
                            Belum Mengisi
                        </span>

                    @endif

                </td>

            </tr>

            @endforeach

            @else

            <tr>

            <td colspan="6" class="text-center">

            Belum ada data.

            </td>

            </tr>

            @endif

            </tbody>

        </table>

        @if(isset($laporan) && $laporan->count())

        <div class="d-flex justify-content-between align-items-center mt-3">

            <div>

                <strong>Jumlah Data :</strong>
                {{ $laporan->count() }} Alumni

            </div>

            <div>
                <a href="{{ route('laporan.export.excel') }}"
                    class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i>
                    Export Excel
                </a>

            </div>

        </div>

        @endif

    </div>

</div>

@endsection
