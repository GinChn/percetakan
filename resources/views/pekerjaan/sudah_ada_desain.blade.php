@extends('layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Sudah Ada Desain</h4>
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
                                    <th>Nama Pelanggan</th>
                                    <th>Nama Pesanan</th>
                                    <th>Jenis Barang</th>
                                    <th>P</th>
                                    <th>L</th>
                                    <th>QTY</th>
                                    <th>Finishing</th>

                                    <th>Aksi</th>
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
                                        <td>
                                            <a href="#" class="btn-sm btn-info">Kerjakan</a>
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
