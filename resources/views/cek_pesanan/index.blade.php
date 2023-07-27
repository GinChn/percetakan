<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AAL Printing | Cek Pesanan</title>
    <link rel="icon" sizes="16x16" href="{{ asset('assets/dist/img/logo.png') }}" />
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
    <link rel="stylesheet" href="{{ asset('assets/dist/css/custom/cek-pesanan.css') }}">
</head>

<body>
    <div class="background-wrapper">
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


        <div class="container">
            <div class="banner ">
                <div class="text-banner">
                    <h3>Cek Status Pesanan</h3>
                    <p>**Pesanan dengan status selesai sudah bisa diambil.</p>
                    <p class="contact">Informasi lebih lanjut:</p>
                    <p class="contact">Telp/wa 0895 4111 95023</p>
                </div>
                <img src="{{ asset('assets/dist/img/printing-illust.png') }}" alt="gambar" style="height: 300px">
            </div>
        </div>
        <div class="container my-2 content-below-banner">
            <div class="row">
                <div class="col md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Cek Status Pesanan</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="table-cek-pesanan">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col" class="show-desktop">Tanggal</th>
                                        <th scope="col" class="show-desktop">No Nota</th>
                                        <th scope="col">Atas Nama</th>
                                        <th scope="col" class="show-desktop">Status Pesanan
                                        </th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pesanan as $item)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td class="show-desktop">{{ tanggal_indonesia($item->created_at) }}</td>
                                            <td class="show-desktop">{{ $item->no_nota }}</td>
                                            <td>{{ $item->nama_pelanggan }}</td>
                                            <td class="show-desktop"><span
                                                    class="badge {{ $item->status_pesanan === 'Selesai' ? 'badge-success' : 'badge-warning' }}">
                                                    {{ $item->status_pesanan }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="/cek-pesanan/{{ $item->no_nota }}"
                                                    class="btn btn-sm btn-primary">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Whatsapp -->
            <div class="text-center mt-4 ">
                <a class="btn btn-success btn-whatsapp" href="#!" role="button">
                    <i class="fab fa-whatsapp mr-2"></i>Whatsapp
                </a>
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
    {{-- Data Table --}}
    <script>
        $(function() {


            $(document).ready(function() {
                $('#table-cek-pesanan').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true
                });
            });

        });
    </script>
    <script>
        @if (isset($errorMessage))
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            document.addEventListener("DOMContentLoaded", function() {
                Toast.fire({
                    icon: 'error',
                    title: '{{ $errorMessage }}',
                    timer: 3000
                });
            });
        @endif
    </script>

</body>

</html>
