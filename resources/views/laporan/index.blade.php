@extends('layout')

@section('content')
    @php
        $data_laporan = session('data_laporan');
        $data_input = session('data_input');
        
        // Cek apakah data_laporan kosong
        if (empty($data_laporan)) {
            // Atur nilai default atau kosongkan variabel jika sesuai dengan kebutuhan
            $data_laporan = []; // Contoh: set data_laporan sebagai array kosong
        }
        
        // Cek apakah data_input kosong
        if (empty($data_input)) {
            // Atur nilai default atau kosongkan variabel jika sesuai dengan kebutuhan
            $data_input = []; // Contoh: set data_input sebagai array kosong
        }
    @endphp


    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan</h1>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="container-fluid"> --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('submit_tanggal') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">

                                <div class="form-group d-flex align-items-center" style="height:100%">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="pilihLaporan">Laporan</label>
                                        </div>
                                        <select class="custom-select" id="pilihLaporan" name="jenis_laporan">
                                            <option value="">--Pilih Jenis Laporan--</option>
                                            <option value="harian"
                                                {{ session()->has('data_input') && session('data_input')['jenis_laporan'] === 'harian' ? 'selected' : '' }}>
                                                Harian
                                            </option>
                                            <option value="bulanan"
                                                {{ session()->has('data_input') && session('data_input')['jenis_laporan'] === 'bulanan' ? 'selected' : '' }}>
                                                Periode
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-5 pick_harian" {!! session()->has('data_input') && session('data_input')['jenis_laporan'] === 'harian'
                                ? ''
                                : 'style="display: none;"' !!}>
                                <div class="form-group d-flex align-items-center" style="height:100%">
                                    <input type="date" class="form-control" id="dateInput" placeholder="Select date"
                                        name="tanggal_laporan"
                                        value="{{ session()->has('data_input') ? session('data_input')['tanggal_laporan'] : '' }}">
                                </div>
                            </div>
                            <div class="col-md-5 pick_bulanan" {!! session()->has('data_input') && session('data_input')['jenis_laporan'] === 'bulanan'
                                ? ''
                                : 'style="display: none;"' !!}>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group d-flex align-items-center" style="height:100%">
                                            <input type="date" class="form-control" id="dateInput"
                                                placeholder="Select date" name="tanggal_laporan_awal"
                                                value="{{ session()->has('data_input') ? session('data_input')['tanggal_laporan_awal'] : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group d-flex align-items-center" style="height:100%">
                                            <input type="date" class="form-control" id="dateInput"
                                                placeholder="Select date" name="tanggal_laporan_akhir"
                                                value="{{ session()->has('data_input') ? session('data_input')['tanggal_laporan_akhir'] : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="button-tgl d-flex align-items-center justify-content-end" style="height:100%;">
                                    <button type="submit" class="btn btn-primary tombol_cek shadow-none btn-sm"
                                        style="width:100%; text-align:center; {!! session()->has('data_input') ? '' : 'display: none;"' !!}">Cek</button>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="d-flex align-items-center justify-content-end" style="height:100%;">
                                    @if (session()->has('data_input') && session('data_input')['jenis_laporan'])
                                        <a href="{{ route('export.excel', ['jenis_laporan' => session('data_input')['jenis_laporan'], 'tanggal_laporan' => session('data_input')['tanggal_laporan'], 'tanggal_laporan_awal' => session('data_input')['tanggal_laporan_awal'], 'tanggal_laporan_akhir' => session('data_input')['tanggal_laporan_akhir']]) }}"
                                            class="btn-sm btn-success export-excel"
                                            style="width:100%; text-align:center; {!! session()->has('data_input') ? '' : 'display: none;"' !!}"><i
                                                class="fa fa-download sm" aria-hidden="true"></i><span
                                                class="ml-1">XLS</span></a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="d-flex align-items-center justify-content-end" style="height:100%;">
                                    @if (session()->has('data_input') && session('data_input')['jenis_laporan'])
                                        <a href="{{ route('export.pdf', ['jenis_laporan' => session('data_input')['jenis_laporan'], 'tanggal_laporan' => session('data_input')['tanggal_laporan'], 'tanggal_laporan_awal' => session('data_input')['tanggal_laporan_awal'], 'tanggal_laporan_akhir' => session('data_input')['tanggal_laporan_akhir']]) }}"
                                            class="btn-sm btn-secondary export-pdf"
                                            style="width:100%; text-align:center; {!! session()->has('data_input') ? '' : 'display: none;"' !!}"><i
                                                class="fa fa-download sm" aria-hidden="true"></i><span
                                                class="ml-1">PDF</span></a>
                                    @endif
                                </div>
                            </div>



                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}

    @if ($data_input)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Pemasukan

                            @if ($data_input['jenis_laporan'] == 'harian')
                                {{ tanggal_indonesia($data_input['tanggal_laporan'], false) }}
                            @else
                                {{ tanggal_indonesia($data_input['tanggal_laporan_awal'], false) }} -
                                {{ tanggal_indonesia($data_input['tanggal_laporan_akhir'], false) }}
                            @endif
                        </h5>
                    </div>
                    <div class="card-body">

                        @if ($data_input['jenis_laporan'] == 'harian')
                            <table id="table2_pemasukan" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Nota</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data_laporan['data_masuk'])
                                        @foreach ($data_laporan['data_masuk'] as $index => $masuk)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $masuk->no_nota }}</td>
                                                <td>{{ $masuk->nama_pelanggan }}</td>
                                                <td class="total-masuk">{{ format_uang($masuk->total) }}</td>
                                                <td>
                                                    <a href="laporan/{{ $masuk->id_pesanan }}"
                                                        class="btn-sm btn-primary">Detail</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        @elseif($data_input['jenis_laporan'] == 'bulanan')
                            <table id="table2_pemasukan" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Pemasukan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data_laporan['data_masuk'])
                                        @foreach ($data_laporan['data_masuk'] as $index => $masuk)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ tanggal_indonesia($masuk->tanggal, false) }}</td>
                                                <td class="total-masuk">{{ format_uang($masuk->total_tagihan) }}</td>
                                                <td><a href="{{ route('pesanan_periode', ['tanggal' => $masuk->tanggal]) }}"
                                                        class="btn-sm btn-primary">Detail</a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        @endif
                        <div class="total col-md-6 bg-black float-right">
                            <div class="row ">
                                <div class="col d-flex justify-content-end">
                                    <p class="text-bold d-flex align-items-center" style="height:100%;">Total
                                        Pemasukan =</p>
                                </div>
                                <div class="col d-flex justify-content-center">
                                    <p id="total-angka-masuk" class="text-bold d-flex align-items-center"
                                        style="height:100%;">
                                        {{ format_uang($data_laporan['total_masuk']) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Pengeluaran
                            @if ($data_input['jenis_laporan'] == 'harian')
                                {{ tanggal_indonesia($data_input['tanggal_laporan'], false) }}
                            @else
                                {{ tanggal_indonesia($data_input['tanggal_laporan_awal'], false) }} -
                                {{ tanggal_indonesia($data_input['tanggal_laporan_akhir'], false) }}
                            @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($data_input['jenis_laporan'] == 'harian')
                            <table id="table2_pengeluaran" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>keterangan</th>
                                        <th>Nominal</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data_laporan['data_keluar'])
                                        @foreach ($data_laporan['data_keluar'] as $index => $keluar)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $keluar->keterangan }}</td>
                                                <td>{{ format_uang($keluar->nominal) }}</td>
                                                <td>{{ $keluar->jumlah }}</td>
                                                <td class="total-keluar">{{ format_uang($keluar->total) }}</td>

                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        @elseif($data_input['jenis_laporan'] == 'bulanan')
                            <table id="table2_pengeluaran" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Pengeluaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data_laporan['data_keluar'])
                                        @foreach ($data_laporan['data_keluar'] as $index => $keluar)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ tanggal_indonesia($keluar->tanggal) }}</td>
                                                <td class="total-keluar">{{ format_uang($keluar->total_pengeluaran) }}
                                                </td>
                                                <td><a href="{{ route('pengeluaran_periode', ['tanggal' => $keluar->tanggal]) }}"
                                                        class="btn-sm btn-primary">Detail</a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        @endif
                        <div class="total col-md-6 bg-black float-right">
                            <div class="row ">
                                <div class="col d-flex justify-content-end">
                                    <p class="text-bold d-flex align-items-center" style="height:100%;">Total
                                        Pengeluaran =</p>
                                </div>
                                <div class="col d-flex justify-content-center">
                                    <p id="total-angka-keluar" class="text-bold d-flex align-items-center"
                                        style="height:100%;">
                                        {{ format_uang($data_laporan['total_keluar']) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Pemasukan Bersih

                            @if ($data_input['jenis_laporan'] == 'harian')
                                {{ tanggal_indonesia($data_input['tanggal_laporan'], false) }}
                            @else
                                {{ tanggal_indonesia($data_input['tanggal_laporan_awal'], false) }} -
                                {{ tanggal_indonesia($data_input['tanggal_laporan_akhir'], false) }}
                            @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="total col-md-6 bg-black float-right">
                            <div class="row ">
                                <div class="col d-flex justify-content-end">
                                    <p class="text-bold d-flex align-items-center" style="height:100%;">
                                        BERSIH =</p>
                                </div>
                                <div class="col d-flex justify-content-center">
                                    <p id="total-bersih" class="text-bold d-flex align-items-center"
                                        style="height:100%;">
                                        {{ format_uang($data_laporan['total_bersih']) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Total Bahan Keluar

                            @if ($data_input['jenis_laporan'] == 'harian')
                                {{ tanggal_indonesia($data_input['tanggal_laporan'], false) }}
                            @else
                                {{ tanggal_indonesia($data_input['tanggal_laporan_awal'], false) }} -
                                {{ tanggal_indonesia($data_input['tanggal_laporan_akhir'], false) }}
                            @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($data_input['jenis_laporan'] == 'harian' || $data_input['jenis_laporan'] == 'bulanan')
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bahan</th>
                                        <th>Jumlah Keluar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data_laporan['total_bahan'])
                                        @foreach ($data_laporan['total_bahan'] as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
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
                                    @endif
                                </tbody>

                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @endif
@endsection

@section('script')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script>
        let totalJumlahMasuk = 0;
        let totalJumlahKeluar = 0;
        let totalBersih = 0;

        // menampilkan inputan tanggal harian atau range bulanan
        $(document).ready(function() {

            $('#pilihLaporan').change(function() {
                let pilihLaporan = $(this).val();

                $('.pick_harian, .pick_bulanan').hide();
                $('.tombol_cek').hide();

                if (pilihLaporan === 'harian') {
                    $('.pick_harian, .tombol_cek, .export-pdf, .export-excel').show();
                } else if (pilihLaporan === 'bulanan') {
                    $('.pick_bulanan, .tombol_cek, .export-pdf, .export-excel').show();
                }

            });
        });
    </script>
    @if (Session::has('gagal-export'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'error',
                    title: '{{ Session::get('gagal-export') }}',
                    timer: 3000,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false
                });
            });
        </script>
    @endif
@endsection
