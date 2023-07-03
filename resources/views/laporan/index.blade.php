@extends('layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('submit_tanggal') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">

                                    <div class="form-group d-flex align-items-center" style="height:100%">
                                        {{-- <label for="dropdownInput">Jenis Laporan</label> --}}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="pilihLaporan">Laporan</label>
                                            </div>
                                            <select class="custom-select" id="pilihLaporan" name="jenis_laporan">
                                                <option value="">--Pilih Jenis Laporan--</option>
                                                <option value="harian"
                                                    {{ isset($data_input['jenis_laporan']) && $data_input['jenis_laporan'] == 'harian' ? 'selected' : '' }}>
                                                    Harian
                                                </option>
                                                <option value="bulanan"
                                                    {{ isset($data_input['jenis_laporan']) && $data_input['jenis_laporan'] == 'bulanan' ? 'selected' : '' }}>
                                                    Bulanan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 pick_harian" {!! isset($data_input['jenis_laporan']) && $data_input['jenis_laporan'] == 'harian'
                                    ? ''
                                    : 'style="display: none;"' !!}>
                                    <div class="form-group d-flex align-items-center" style="height:100%">
                                        <input type="date" class="form-control" id="dateInput" placeholder="Select date"
                                            name="tanggal_laporan"
                                            value="{{ isset($data_input['tanggal_laporan']) ? $data_input['tanggal_laporan'] : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-5 pick_bulanan" {!! isset($data_input['jenis_laporan']) && $data_input['jenis_laporan'] == 'bulanan'
                                    ? ''
                                    : 'style="display: none;"' !!}>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group d-flex align-items-center" style="height:100%">
                                                <input type="date" class="form-control" id="dateInput"
                                                    placeholder="Select date" name="tanggal_laporan_awal"
                                                    value="{{ isset($data_input['tanggal_laporan_awal']) ? $data_input['tanggal_laporan_awal'] : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group d-flex align-items-center" style="height:100%">
                                                <input type="date" class="form-control" id="dateInput"
                                                    placeholder="Select date" name="tanggal_laporan_akhir"
                                                    value="{{ isset($data_input['tanggal_laporan_akhir']) ? $data_input['tanggal_laporan_akhir'] : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="button-tgl d-flex align-items-center justify-content-end"
                                        style="height:100%;">
                                        <button type="submit" class="btn-sm btn-primary tombol_cek"
                                            style="width:100%; text-align:center; display:none">Cek</button>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="d-flex align-items-center justify-content-end" style="height:100%;">
                                        <button type="submit" class="btn-sm btn-success "
                                            style="width:100%; text-align:center; "><i class="fa fa-download"
                                                aria-hidden="true"></i><span class="ml-1">Excel</span></button>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="d-flex align-items-center justify-content-end" style="height:100%;">
                                        <button type="submit" class="btn-sm btn-secondary "
                                            style="width:100%; text-align:center; "><i class="fa fa-download"
                                                aria-hidden="true"></i><span class="ml-1">PDF</span></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (isset($data_input))
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Pemasukan</h5>
                    </div>
                    <div class="card-body">

                        @if ($data_input['jenis_laporan'] == 'harian')
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Nota</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Total Tagihan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($data_laporan['data_masuk']))
                                        @foreach ($data_laporan['data_masuk'] as $index => $masuk)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $masuk->no_nota }}</td>
                                                <td>{{ $masuk->nama_pelanggan }}</td>
                                                <td class="total-masuk">{{ $masuk->total }}</td>
                                                <td>
                                                    <a href="#" class="btn-sm btn-primary">Detail</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        @elseif($data_input['jenis_laporan'] == 'bulanan')
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Pemasukan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($data_laporan['data_masuk']))
                                        @foreach ($data_laporan['data_masuk'] as $index => $masuk)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $masuk->tanggal }}</td>
                                                <td class="total-masuk">{{ $masuk->total_tagihan }}</td>
                                                <td><a href="#" class="btn-sm btn-primary">Detail</a></td>
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
                        <h5 class="card-title">Pengeluaran</h5>
                    </div>
                    <div class="card-body">
                        @if ($data_input['jenis_laporan'] == 'harian')
                            <table class="table">
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
                                    @if (isset($data_laporan['data_keluar']))
                                        @foreach ($data_laporan['data_keluar'] as $index => $keluar)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $keluar->keterangan }}</td>
                                                <td>{{ $keluar->harga }}</td>
                                                <td>{{ $keluar->jumlah }}</td>
                                                <td class="total-keluar">{{ $keluar->total }}</td>

                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        @elseif($data_input['jenis_laporan'] == 'bulanan')
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Pengeluaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($data_laporan['data_keluar']))
                                        @foreach ($data_laporan['data_keluar'] as $index => $keluar)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $keluar->tanggal }}</td>
                                                <td class="total-keluar">{{ $keluar->total_pengeluaran }}</td>
                                                <td><a href="#" class="btn-sm btn-primary">Detail</a></td>
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
                        <h5 class="card-title">Pemasukan Bersih</h5>
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
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    @endif
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    $('.pick_harian, .tombol_cek').show();
                } else if (pilihLaporan === 'bulanan') {
                    $('.pick_bulanan, .tombol_cek').show();
                }
            });
        });
        // menampilkan jumlah pemasukan dan pengeluaran
        $(document).ready(function() {
            // totalJumlahMasuk = 0;

            $('.total-masuk').each(function() {
                let angkaMasuk = parseInt($(this).text());
                totalJumlahMasuk += angkaMasuk;
            });

            $('#total-angka-masuk').text(totalJumlahMasuk);
        });

        $(document).ready(function() {
            // totalJumlahKeluar = 0;

            $('.total-keluar').each(function() {
                let angkaKeluar = parseInt($(this).text());
                totalJumlahKeluar += angkaKeluar;
            });

            $('#total-angka-keluar').text(totalJumlahKeluar);
        });

        $(document).ready(function() {
            totalBersih = totalJumlahMasuk - totalJumlahKeluar;

            $('#total-bersih').text(totalBersih);
        });
    </script>
@endsection
