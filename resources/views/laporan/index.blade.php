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
    {{-- @if (isset($data))
        {{ $data }}
    @endif --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('submit_tanggal') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group d-flex align-items-center" style="height:100%">
                                        {{-- <label for="dropdownInput">Jenis Laporan</label> --}}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="dropdownInput">Laporan</label>
                                            </div>
                                            <select class="custom-select" id="dropdownInput">
                                                <option selected>Harian</option>
                                                <option value="option1">Bulanan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group d-flex align-items-center" style="height:100%">
                                        {{-- <label for="dateInput">Tanggal</label> --}}
                                        <input type="date" class="form-control" id="dateInput" placeholder="Select date"
                                            name="tanggal_laporan">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="button-tgl d-flex align-items-center justify-content-end"
                                        style="height:100%;">
                                        <button type="submit" class="btn-sm btn-primary "
                                            style="width:100%; text-align:center">Cek</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Pemasukan</h5>
                </div>
                <div class="card-body">
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
                            @if (isset($data_masuk))
                                @foreach ($data_masuk as $index => $masuk)
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
                    <div class="total col-md-6 bg-black float-right">
                        <div class="row ">
                            <div class="col d-flex justify-content-end">
                                <p class="text-bold d-flex align-items-center" style="height:100%;">Total
                                    Pemasukan =</p>
                            </div>
                            <div class="col d-flex justify-content-center">
                                <p id="total-angka-masuk" class="text-bold d-flex align-items-center" style="height:100%;">
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
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>keterangan</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($data_keluar))
                                @foreach ($data_keluar as $index => $keluar)
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
                    <div class="total col-md-6 bg-black float-right">
                        <div class="row ">
                            <div class="col d-flex justify-content-end">
                                <p class="text-bold d-flex align-items-center" style="height:100%;">Total
                                    Pengeluaran =</p>
                            </div>
                            <div class="col d-flex justify-content-center">
                                <p id="total-angka-keluar" class="text-bold d-flex align-items-center" style="height:100%;">
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
                                <p id="total-bersih" class="text-bold d-flex align-items-center" style="height:100%;">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let totalJumlahMasuk = 0;
        let totalJumlahKeluar = 0;
        let totalBersih = 0;
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
