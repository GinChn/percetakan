<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AAL Printing | Detail Status</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/custom/cek-pesanan.css') }}">
    <style>
        @media (max-width: 767.98px) {

            /* Kolom yang akan dimunculkan pada tampilan mobile */
            .mobile-show {
                display: table-cell !important;
            }

            /* Kolom yang akan menjadi bagian dari collapse */
            .mobile-collapse {
                display: none;
            }

            .collapse-row {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
            }

            .show-row {
                max-height: 1000px;
                /* Atur nilai maksimum yang cukup besar agar animasi lancar */
                transition: max-height 0.3s ease;
            }

            /* Tambahkan kelas custom-accordion pada tabel untuk mengatur seluruh row dapat di-collapse */
            .custom-accordion tr[data-bs-toggle="collapse"] {
                cursor: pointer;
            }
        }
    </style>
</head>

<body>
    <div class="background-wrapper" style="min-height: 100vh">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <img src="{{ asset('assets/dist/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image"
                    style="opacity: .8;">
                <span class="brand-text">AAL Printing</span>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            {{-- <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a> --}}
                        </li>
                    </ul>
                    <a href="/login" class="btn btn-sm btn-secondary my-2 my-sm-0">LOGIN</a>
                </div>
            </div>
        </nav>

        <div class="container my-3">
            <div class="container-fluid">
                @foreach ($data as $item)
                    <div
                        class="invoice p-3 mb-3 card-outline card-{{ $item->status_pesanan === 'Selesai' ? 'success' : 'secondary' }}">
                @endforeach
                <div class="row" style="margin-bottom: 30px">
                    <div class="col-sm-8">
                        <table>
                            <tr>
                                <td>No Nota</td>
                                @foreach ($data as $item)
                                    <td>: <b>{{ $item->no_nota }}</b></td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                @foreach ($data as $item)
                                    <td>: <b>{{ tanggal_indonesia($item->created_at) }}</b></td>
                                @endforeach
                            </tr>
                        </table>
                    </div>

                    <div class="col-sm-4">
                        <table>
                            <tr>
                                <td>Pelanggan</td>
                                @foreach ($data as $item)
                                    <td>: <b>{{ $item->nama_pelanggan }}</b></td>
                                @endforeach

                            </tr>
                            <tr>
                                <td>No Telp</td>
                                @foreach ($data as $item)
                                    <td>: <b>{{ $item->no_telp }}</b></td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped custom-accordion" id="table2_cek_status">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th scope="col">Nama Pesanan</th>
                                    <th scope="col" class="mobile-collapse">Jenis Barang</th>
                                    <th scope="col" class="mobile-collapse">Panjang</th>
                                    <th scope="col" class="mobile-collapse">Lebar</th>
                                    <th scope="col" class="mobile-collapse">Jumlah</th>
                                    <th scope="col" class="mobile-collapse">Finishing</th>
                                    <th scope="col" class="mobile-show">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detail as $item)
                                    <tr data-bs-toggle="collapse" data-bs-target="#collapseRow{{ $loop->iteration }}"
                                        aria-expanded="false" aria-controls="collapseRow{{ $loop->iteration }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_pesanan }}</td>
                                        <td class="mobile-collapse">{{ $item->nama_barang }}</td>
                                        <td class="mobile-collapse">{{ $item->panjang }}</td>
                                        <td class="mobile-collapse">{{ $item->lebar }}</td>
                                        <td class="mobile-collapse">{{ $item->jumlah }}</td>
                                        <td class="mobile-collapse">{{ $item->nama_finishing }}</td>
                                        <td class="mobile-show">
                                            <span
                                                class="badge {{ getStatusColor($item->status_detail) }}">{{ $item->status_detail }}</span>
                                        </td>
                                    </tr>
                                    <tr class="collapse" id="collapseRow{{ $loop->iteration }}">
                                        <td colspan="8">
                                            <!-- Konten kolom yang akan muncul di collapse -->
                                            Jenis Barang: {{ $item->nama_barang }}<br>
                                            Panjang: {{ $item->panjang }}<br>
                                            Lebar: {{ $item->lebar }}<br>
                                            Jumlah: {{ $item->jumlah }}<br>
                                            Finishing: {{ $item->nama_finishing }}<br>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-12">
                        <a href="/cek-pesanan" class="btn btn-danger btn-sm float-right">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    {{-- Sweet Alert2 --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Ketika baris pada tabel diklik
            $('#table2_cek_status tbody tr').click(function() {
                // Toggle collapse yang sesuai berdasarkan atribut data-bs-target
                $($(this).data('bs-target')).collapse('toggle');
            });
        });
    </script>
</body>

</html>
