@extends('layouts.app')

@section('content')

<div class="card shadow">

    <div class="card-header bg-primary text-white">

        <h4 class="mb-0">
            <i class="bi bi-file-earmark-text"></i>
            Data Hasil Kuesioner
        </h4>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-striped">

                <thead class="table-dark">

                    <tr>

                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Tanggal Isi</th>
                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($respon as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->nim }}</td>

                        <td>{{ $item->alumni->nama }}</td>

                        <td>{{ $item->tanggal_isi }}</td>

                        <td>

                            <a href="{{ route('hasil.show',$item->id_respon) }}"
                                class="btn btn-success btn-sm">

                                <i class="bi bi-eye"></i>

                                Detail

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5" class="text-center">

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