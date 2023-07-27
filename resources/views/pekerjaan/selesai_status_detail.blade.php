@extends('layout')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/dist/css/custom/checkbox.css') }}">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Pekerjaan Selesai</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <table id="table2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nota</th>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    <th>Pesanan</th>
                                    <th>Barang</th>
                                    <th>P</th>
                                    <th>L</th>
                                    <th>QTY</th>
                                    <th>Finishing</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->no_nota }}</td>
                                        <td>{{ tanggal_indonesia($item->created_at) }}</td>
                                        <td>{{ $item->nama_pelanggan }}</td>
                                        <td>{{ $item->nama_pesanan }}</td>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>{{ $item->panjang }}</td>
                                        <td>{{ $item->lebar }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>{{ $item->nama_finishing }}</td>

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
