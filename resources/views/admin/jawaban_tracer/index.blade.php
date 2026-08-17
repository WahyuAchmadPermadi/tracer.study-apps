@extends('layouts.app')

@section('title', 'Hasil Tracer Study')

@section('content')

<div class="card shadow">

    <div class="card-header bg-success text-white">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h4 class="mb-0">
                    <i class="bi bi-clipboard-check"></i>
                    Hasil Tracer Study Alumni
                </h4>
            </div>

            <div>
                <span class="badge bg-light text-dark">
                    {{ $jawaban->total() }} Responden
                </span>
            </div>

        </div>

    </div>

    <div class="card-body">

        <p class="text-muted">
            Daftar alumni yang telah menyelesaikan dan mengirim
            kuesioner tracer study.
        </p>

        <form action="{{ route('admin.jawaban-tracer.index') }}" method="GET"
            class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">

            <div class="w-100" style="max-width: 420px;">
                <div class="input-group">
                    <input type="search" name="search" value="{{ $search }}" class="form-control"
                        placeholder="Cari NIM atau nama alumni..." aria-label="Cari NIM atau nama alumni">
                    <button type="submit" class="btn btn-primary" title="Cari" aria-label="Cari">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                <select name="id_periode" class="form-select" style="width: 180px;">
                    <option value="">Semua Periode</option>
                    @foreach($periodeOptions as $periode)
                        <option value="{{ $periode->id_periode }}" @selected((string) $idPeriode === (string) $periode->id_periode)>
                            {{ $periode->tahun }}
                        </option>
                    @endforeach
                </select>

                <select name="tahun_lulus" class="form-select" style="width: 180px;">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunLulusOptions as $tahun)
                        <option value="{{ $tahun }}" @selected((string) $tahunLulus === (string) $tahun)>
                            {{ $tahun }}
                        </option>
                    @endforeach
                </select>

                <select name="program_studi" class="form-select" style="width: 280px;">
                    <option value="">Semua Program Studi</option>
                    @foreach($programStudis as $nama)
                        <option value="{{ $nama }}" @selected($programStudi === $nama)>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-primary" title="Terapkan Filter" aria-label="Terapkan Filter">
                    <i class="bi bi-funnel"></i>
                </button>

                <a href="{{ route('admin.jawaban-tracer.index') }}" class="btn btn-outline-secondary"
                    title="Reset Filter" aria-label="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>

        </form>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle tracer-answer-table">

                <thead class="table-dark">

                    <tr>

                        <th width="5%" class="text-center">
                            No
                        </th>

                        <th>
                            NIM
                        </th>

                        <th>
                            Nama Alumni
                        </th>

                        <th>
                            Program Studi
                        </th>

                        <th>
                            Tahun Lulus
                        </th>

                        <th>
                            Status Saat Ini
                        </th>

                        <th>
                            Tanggal Mengisi
                        </th>

                        <th width="10%" class="text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($jawaban as $item)

                        <tr>

                            <td class="text-center">
                                {{ $jawaban->firstItem() + $loop->index }}
                            </td>

                            <td>
                                {{ $item->alumni->nim ?? '-' }}
                            </td>

                            <td>
                                {{ $item->alumni->nama ?? '-' }}
                            </td>

                            <td>
                                {{ $item->alumni->program_studi ?? '-' }}
                            </td>

                            <td>
                                {{ $item->alumni->tahun_lulus ?? '-' }}
                            </td>

                            <td>

                                @if($item->status)

                                    <span class="badge bg-success">
                                        {{ $item->status }}
                                    </span>

                                @else

                                    <span class="text-muted">
                                        -
                                    </span>

                                @endif

                            </td>

                            <td>

                                @if($item->submitted_at)

                                    {{ \Carbon\Carbon::parse($item->submitted_at)
                                        ->format('d-m-Y H:i') }}

                                @else

                                    -

                                @endif

                            </td>

                            <td class="text-center">

                                <a href="{{ route('admin.jawaban-tracer.show', $item->id_jawaban) }}"
                                    class="btn btn-primary btn-sm">

                                    <i class="bi bi-eye"></i>
                                    Detail

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8"
                                class="text-center text-muted py-4">

                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>

                                Belum ada alumni yang mengirim
                                hasil tracer study.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">
            {{ $jawaban->links() }}
        </div>

    </div>

</div>

@endsection
