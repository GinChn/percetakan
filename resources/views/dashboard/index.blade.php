@extends('layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Dashboard</h3>
                </div>
            </div>
        </div>
    </section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="callout callout-success">
                    <h5>Selamat Datang!</h5>
                    <p>{{ auth()->user()->nama }}</p>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-danger">
                    <div class="inner">
                        <h3>{{ $desain_belum }}</h3>
                        <p>Desain Belum Selesai</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-file-excel"></i>
                    </div>
                    <a href="/pekerjaan/belum-ada-desain" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-warning">
                    <div class="inner">
                        <h3>{{ $desain_selesai }}</h3>
                        <p>Desain Selesai</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-file"></i>
                    </div>
                    <a href="/pekerjaan/sudah-ada-desain" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-info">
                    <div class="inner">
                        <h3>{{ $pekerjaan_dikerjakan }}</h3>
                        <p>Pesanan Dikerjakan</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-hourglass-half"></i>
                    </div>
                    <a href="/pekerjaan/dikerjakan" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-success">
                    <div class="inner">
                        <h3>{{ $pekerjaan_selesai }}</h3>
                        <p>Pesanan Selesai</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check"></i>
                    </div>
                    <a href="/pekerjaan/selesai" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>




        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title">Pengeluaran Bahan {{ tanggal_indonesia($tgl_awalBulan, false) }} s/d
                            {{ tanggal_indonesia($tgl_akhirBulan, false) }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Bahan</th>
                                    <th>Jumlah Keluar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($totalbahan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_bahan }}</td>
                                        <td>
                                            @if ($item->satuan == 'Meter')
                                                {{ $item->total_keluar }} {{ $item->satuan }}
                                            @else
                                                {{ $item->total_jumlah }} {{ $item->satuan }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @if (auth()->check())
        <!-- Check if the user is authenticated -->
        <script>
            // Add Cache-Control header to disable caching for authenticated users
            document.addEventListener('DOMContentLoaded', function() {
                // Set the Cache-Control header to prevent caching
                // For most browsers, the following directives should work:
                // no-cache: Forces caches to submit the request to the origin server for validation before releasing a cached copy.
                // no-store: Instructs caches not to store a cached copy of the response.
                // must-revalidate: Tells caches that they must obey any freshness information you give them about a representation.
                // This combination should prevent the page from being cached.
                document.querySelector('meta[name="viewport"]').content = 'no-cache, no-store, must-revalidate';
            });
        </script>
    @endif
@endpush

@section('script')
    <script>
        $(function() {
            var PendapatanCanvas = $('#pendapatanChart').get(0).getContext('2d')

            var PendapatanData = {
                labels: {{ json_encode($data_tanggal) }},
                datasets: [{
                    label: 'Pendapatan',
                    backgroundColor: '',
                    borderColor: '#00a65a',
                    // pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: false,
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: {{ json_encode($data_pendapatan) }}
                }, ]
            }

            var PendapatanOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }]
                }
            }
            PendapatanData.datasets[0].fill = false;
            PendapatanOptions.datasetFill = false

            var PendapatanChart = new Chart(PendapatanCanvas, {
                type: 'line',
                data: PendapatanData,
                options: PendapatanOptions
            })
        })
    </script>
@endsection
