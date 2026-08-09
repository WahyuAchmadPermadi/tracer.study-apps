<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Laporan Tracer Study Alumni</title>

    <style>

        @page {
            margin: 25px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
        }

        /* ================================
        HEADER
        ================================= */

        .header {
            text-align: center;
            border-bottom: 2px solid #0B5D3B;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }

        .header h2 {
            margin: 0;
            font-size: 17px;
            color: #0B5D3B;
        }

        .header h3 {
            margin: 5px 0 0;
            font-size: 14px;
        }

        .header p {
            margin: 4px 0 0;
            font-size: 9px;
            color: #555;
        }


        /* ================================
        INFORMASI LAPORAN
        ================================= */

        .info {
            width: 100%;
            margin-bottom: 18px;
        }

        .info td {
            padding: 2px 4px;
            vertical-align: top;
        }

        .info-label {
            width: 110px;
            font-weight: bold;
        }

        .info-separator {
            width: 10px;
        }


        /* ================================
        JUDUL BAGIAN
        ================================= */

        .section-title {
            background: #0B5D3B;
            color: white;
            padding: 7px 10px;
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 0;
        }


        /* ================================
        TABEL DATA
        ================================= */

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .data-table th {
            background: #198754;
            color: white;
            border: 1px solid #999;
            padding: 6px 4px;
            text-align: center;
            font-size: 8px;
        }

        .data-table td {
            border: 1px solid #bbb;
            padding: 5px 4px;
            font-size: 8px;
            vertical-align: top;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }


        /* ================================
        STATUS
        ================================= */

        .status-sudah {
            color: #0B5D3B;
            font-weight: bold;
        }

        .status-belum {
            color: #dc3545;
            font-weight: bold;
        }


        /* ================================
        RINGKASAN
        ================================= */

        .summary {
            width: 45%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .summary td {
            border: 1px solid #bbb;
            padding: 6px 8px;
        }

        .summary-label {
            font-weight: bold;
            background: #f2f2f2;
        }


        /* ================================
        FOOTER
        ================================= */

        .footer {
            margin-top: 25px;
            padding-top: 8px;
            border-top: 1px solid #aaa;
            font-size: 8px;
            color: #666;
        }

    </style>

</head>

<body>


{{-- =====================================
    HEADER
===================================== --}}

<div class="header">

    <h2>
        UNIVERSITAS NAHDLATUL ULAMA KALIMANTAN BARAT
    </h2>

    <h3>
        LAPORAN TRACER STUDY ALUMNI
    </h3>

    <p>
        Sistem Informasi Tracer Study Alumni
    </p>

</div>


{{-- =====================================
    INFORMASI FILTER
===================================== --}}

<table class="info">

    <tr>
        <td class="info-label">Tanggal Cetak</td>
        <td class="info-separator">:</td>
        <td>{{ date('d-m-Y') }}</td>
    </tr>

    <tr>
        <td class="info-label">Tahun Lulus</td>
        <td class="info-separator">:</td>
        <td>{{ $tahun ?: 'Semua' }}</td>
    </tr>

    <tr>
        <td class="info-label">Program Studi</td>
        <td class="info-separator">:</td>
        <td>{{ $prodi ?: 'Semua' }}</td>
    </tr>

    <tr>
        <td class="info-label">Status</td>
        <td class="info-separator">:</td>

        <td>

            @if($status == 'sudah')

                Sudah Mengisi

            @elseif($status == 'belum')

                Belum Mengisi

            @else

                Semua

            @endif

        </td>

    </tr>

    <tr>
        <td class="info-label">Jumlah Data</td>
        <td class="info-separator">:</td>
        <td>{{ $totalAlumni }} Alumni</td>
    </tr>

</table>


{{-- =====================================
    DATA ALUMNI
===================================== --}}

<div class="section-title">
    DATA TRACER STUDY ALUMNI
</div>

<table class="data-table">

    <thead>

        <tr>

            <th width="3%">No</th>

            <th width="8%">NIM</th>

            <th width="14%">Nama</th>

            <th width="10%">Program Studi</th>

            <th width="6%">Tahun Lulus</th>

            <th width="10%">Status Saat Ini</th>

            <th width="15%">Instansi / Perusahaan</th>

            <th width="10%">Jabatan</th>

            <th width="11%">Pendapatan</th>

            <th width="13%">Status Pengisian</th>

        </tr>

    </thead>


    <tbody>

        @forelse($alumni as $item)

            @php
                $jawaban = $item->jawabanTracer;
            @endphp

            <tr>

                <td class="center">
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $item->nim }}
                </td>

                <td>
                    {{ $item->nama }}
                </td>

                <td>
                    {{ $item->program_studi }}
                </td>

                <td class="center">
                    {{ $item->tahun_lulus }}
                </td>


                {{-- STATUS SAAT INI --}}

                <td>

                    @if($jawaban)

                        {{ $jawaban->status ?: '-' }}

                    @else

                        -

                    @endif

                </td>


                {{-- PERUSAHAAN --}}

                <td>

                    @if($jawaban)

                        {{ $jawaban->nama_perusahaan ?: '-' }}

                    @else

                        -

                    @endif

                </td>


                {{-- JABATAN --}}

                <td>

                    @if($jawaban)

                        {{ $jawaban->jabatan ?: '-' }}

                    @else

                        -

                    @endif

                </td>


                {{-- PENDAPATAN --}}

                <td class="right">

                    @if($jawaban && $jawaban->pendapatan)

                        Rp {{ number_format(
                            $jawaban->pendapatan,
                            0,
                            ',',
                            '.'
                        ) }}

                    @else

                        -

                    @endif

                </td>


                {{-- STATUS PENGISIAN --}}

                <td class="center">

                    @if($jawaban && $jawaban->submitted_at)

                        <span class="status-sudah">
                            Sudah Mengisi
                        </span>

                    @else

                        <span class="status-belum">
                            Belum Mengisi
                        </span>

                    @endif

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="10"
                    class="center">

                    Tidak ada data yang sesuai dengan filter.

                </td>

            </tr>

        @endforelse

    </tbody>

</table>


{{-- =====================================
    RINGKASAN
===================================== --}}

<div class="section-title">
    RINGKASAN
</div>

<table class="summary">

    <tr>

        <td class="summary-label">
            Total Alumni
        </td>

        <td class="center">
            {{ $totalAlumni }}
        </td>

    </tr>


    <tr>

        <td class="summary-label">
            Sudah Mengisi
        </td>

        <td class="center">
            {{ $sudahMengisi }}
        </td>

    </tr>


    <tr>

        <td class="summary-label">
            Belum Mengisi
        </td>

        <td class="center">
            {{ $belumMengisi }}
        </td>

    </tr>


    <tr>

        <td class="summary-label">
            Persentase Pengisian
        </td>

        <td class="center">
            {{ number_format($persentase, 2, ',', '.') }}%
        </td>

    </tr>

</table>


{{-- =====================================
    FOOTER
===================================== --}}

<div class="footer">

    Dokumen ini dihasilkan melalui Sistem Informasi Tracer Study
    Universitas Nahdlatul Ulama Kalimantan Barat.

</div>


</body>

</html>