@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="row g-4">

    <div class="col-lg-3 col-md-6">

        <div class="card stat-card h-100">

            <div class="card-body">

                <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                <div><small class="text-muted">Total Alumni</small><h2 class="fw-bold mt-2 mb-0">{{ $totalAlumni }}</h2></div>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card stat-card h-100">

            <div class="card-body">

                <div class="stat-icon"><i class="bi bi-check-circle-fill"></i></div>
                <div><small class="text-muted">Sudah Mengisi</small><h2 class="fw-bold text-success mt-2 mb-0">{{ $sudahIsi }}</h2></div>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card stat-card h-100">

            <div class="card-body">

                <div class="stat-icon is-danger"><i class="bi bi-person-x-fill"></i></div>
                <div><small class="text-muted">Belum Mengisi</small><h2 class="fw-bold text-danger mt-2 mb-0">{{ $belumIsi }}</h2></div>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card stat-card h-100">

            <div class="card-body">

                <div class="stat-icon is-gold"><i class="bi bi-graph-up-arrow"></i></div>
                <div><small class="text-muted">Persentase Respon</small><h2 class="fw-bold text-warning mt-2 mb-0">{{ $persentase }}%</h2></div>

            </div>

        </div>

    </div>

</div>

<div class="row g-4 mt-2">

    <div class="col-lg-4">

        <div class="card h-100">

            <div class="card-header fw-semibold">

                Ringkasan

            </div>

            <div class="card-body">

                <table class="table mb-0">

                    <tr>

                        <td>Total Alumni</td>

                        <td class="text-end fw-bold">

                            {{ $totalAlumni }}

                        </td>

                    </tr>

                    <tr>

                        <td>Sudah Mengisi</td>

                        <td class="text-end fw-bold text-success">

                            {{ $sudahIsi }}

                        </td>

                    </tr>

                    <tr>

                        <td>Belum Mengisi</td>

                        <td class="text-end fw-bold text-danger">

                            {{ $belumIsi }}

                        </td>

                    </tr>

                    <tr>

                        <td>Persentase</td>

                        <td class="text-end fw-bold text-warning">

                            {{ $persentase }}%

                        </td>

                    </tr>

                </table>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card h-100">

            <div class="card-header fw-semibold">

                Grafik Pengisian

            </div>

            <div class="card-body">

                <canvas id="chartTracer"></canvas>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card h-100">

            <div class="card-header fw-semibold">

                Program Studi

            </div>

            <div class="card-body">

                <canvas id="programChart"></canvas>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('chartTracer'),{

    type:'bar',

    data:{

        labels:['Sudah Mengisi','Belum Mengisi'],

        datasets:[{

            data:[{{ $sudahIsi }},{{ $belumIsi }}]

        }]

    },

    options:{

        responsive:true,

        maintainAspectRatio:false,

        plugins:{
            legend:{
                display:false
            }
        },

        scales:{
            y:{
                beginAtZero:true,
                ticks:{
                    precision:0
                }
            }
        }

    }

});

new Chart(document.getElementById('programChart'),{

    type:'pie',

    data:{

        labels:[

            @foreach($programStudi as $item)

                "{{ $item->program_studi }}",

            @endforeach

        ],

        datasets:[{

            data:[

                @foreach($programStudi as $item)

                    {{ $item->total }},

                @endforeach

            ]

        }]

    },

    options:{

        responsive:true,

        maintainAspectRatio:false,

        plugins:{

            legend:{
                position:'bottom'
            }

        }

    }

});

</script>

@endsection
