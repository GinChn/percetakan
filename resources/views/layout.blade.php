<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AAL Printing |</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
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
    @yield('style')

</head>

<body class="hold-transition sidebar-mini">
    @php
        $nama_level = auth()->user()->level->nama_level;
    @endphp
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/dashboard" class="nav-link">Home</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('assets/dist/img/user.png') }}" class="user-image img-circle elevation-2"
                            alt="User Image">
                        <span class="d-none d-md-inline">{{ auth()->user()->nama }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <li class="user-header bg-success">

                            <img src="{{ asset('assets/dist/img/user.png') }}" class="img-circle elevation-2"
                                alt="User Image">
                            <p>
                                {{ auth()->user()->nama }}
                            </p>
                        </li>
                        <li class="user-footer">
                            <a href="/profile" class="btn btn-default btn-flat">Profile</a>
                            <a href="/logout" class="btn btn-default btn-flat float-right">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <aside class="main-sidebar sidebar-dark-olive elevation-4">
            <a href="/" class="brand-link bg-light">
                <img src="{{ asset('assets/dist/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">AAL Printing</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-header">DASHBOARD</li>
                        <li class="nav-item">
                            <a href="/dashboard" class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        @if ($nama_level == 'Administrator' || $nama_level == 'Desainer' || $nama_level == 'Kasir')
                            <li class="nav-header">TRANSAKSI</li>
                        @endif
                        @if ($nama_level == 'Administrator' || $nama_level == 'Desainer' || $nama_level == 'Kasir' || $nama_level == 'Operator')
                            <li class="nav-item">
                                <a href="/pesanan" class="nav-link {{ Request::is('pesanan*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-file-invoice"></i>
                                    <p>
                                        Pesanan
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if ($nama_level == 'Administrator' || $nama_level == 'Kasir')
                            <li class="nav-item">
                                <a href="/pembayaran"
                                    class="nav-link {{ Request::is('pembayaran*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-money-bill-wave"></i>
                                    <p>
                                        Pembayaran
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (
                            $nama_level == 'Administrator' ||
                                $nama_level == 'Kasir' ||
                                $nama_level == 'Desainer' ||
                                $nama_level == 'Operator' ||
                                $nama_level == 'Manajer')
                            <li class="nav-header">PEKERJAAN</li>
                            <li class="nav-item {{ Request::is('pekerjaan*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-business-time"></i>
                                    <p>
                                        Progres Pesanan
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="/pekerjaan"
                                            class="nav-link {{ Request::is('pekerjaan') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Semua</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/pekerjaan/belum-ada-desain"
                                            class="nav-link {{ Request::is('pekerjaan/belum-ada-desain') ? 'active' : '' }}"">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Belum Ada Desain</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="/pekerjaan/sudah-ada-desain"
                                            class="nav-link {{ Request::is('pekerjaan/sudah-ada-desain') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Sudah Ada Desain</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/pekerjaan/dikerjakan"
                                            class="nav-link {{ Request::is('pekerjaan/dikerjakan') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Dikerjakan</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/pekerjaan/selesai"
                                            class="nav-link {{ Request::is('pekerjaan/selesai') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Selesai</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/pekerjaan/sudah-diambil"
                                            class="nav-link {{ Request::is('pekerjaan/sudah-diambil') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Sudah Diambil</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if ($nama_level == 'Administrator' || $nama_level == 'Kasir')
                            <li class="nav-item">
                                <a href="/pengeluaran"
                                    class="nav-link {{ Request::is('pengeluaran*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-file-export"></i>
                                    <p>
                                        Pengeluaran
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if ($nama_level == 'Administrator' || $nama_level == 'Manajer' || $nama_level == 'Kasir')
                            <li class="nav-header">REPORT</li>
                            <li class="nav-item">
                                <a href="/laporan" class="nav-link {{ Request::is('laporan*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-file"></i>
                                    <p>
                                        Laporan
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if ($nama_level == 'Administrator' || $nama_level == 'Kasir' || $nama_level == 'Desainer' || $nama_level == 'Operator')
                            <li class="nav-header">MASTER</li>
                            <li
                                class="nav-item {{ Request::is('mesin*') || Request::is('bahan*') || Request::is('barang*') || Request::is('karyawan*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link  ">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Data Master
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="/mesin"
                                            class="nav-link {{ Request::is('mesin*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Mesin</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/bahan"
                                            class="nav-link {{ Request::is('bahan*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Bahan</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/barang"
                                            class="nav-link {{ Request::is('barang*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Barang</p>
                                        </a>
                                    </li>
                                    @if ($nama_level == 'Administrator' || $nama_level == 'Kasir')
                                        <li class="nav-item">
                                            <a href="/karyawan"
                                                class="nav-link {{ Request::is('karyawan*') ? 'active' : '' }}">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Data Karyawan</p>
                                            </a>
                                        </li>
                                    @endif

                                </ul>
                            </li>
                        @endif
                        @if ($nama_level == 'Administrator' || $nama_level == 'Kasir')
                            <li class="nav-header">USER</li>

                            <li class="nav-item">
                                <a href="/registrasi"
                                    class="nav-link {{ Request::is('registrasi*') ? 'active' : '' }}"">
                                    <i class="nav-icon fas fa-address-card"></i>
                                    <p>
                                        Registrasi User
                                    </p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content -->
        <div class="content-wrapper">
            <section class="content">
                @yield('content')
            </section>
        </div>
        <!-- /.content -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- wrapper end -->

    <!-- Script -->
    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
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
    {{-- Data Table --}}
    <script>
        $(function() {
            var tableIds = ['#table2', '#table2_pemasukan', '#table2_pengeluaran', '#table2_pekerjaan'

            ];
            $(tableIds.join(', ')).each(function() {
                $(this).DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
            });
        });
    </script>

    @yield('script')
    <!-- Script End -->
</body>

</html>
