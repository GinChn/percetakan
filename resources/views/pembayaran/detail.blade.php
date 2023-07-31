@extends('layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Pembayaran</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="invoice p-3 mb-3 card-outline card-success">
            <div class="row" style="margin-bottom: 10px">
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-2">
                            <table>
                                <tr>
                                    <td>No Nota</td>
                                </tr>
                                <tr>
                                    <td>Kasir</td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-4">
                            <table>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>: <b>{{ $item->no_nota }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>: <b>{{ $item->kasir }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>: <b>{{ tanggal_indonesia($item->created_at) }}</b></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-3">
                            <table>
                                <tr>
                                    <td>Pelanggan</td>
                                </tr>
                                <tr>
                                    <td>No Telp</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-5">
                            <table>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>: <b>{{ $item->nama_pelanggan }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>: <b>{{ $item->no_telp }}</b></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Pesanan</th>
                                <th>Barang</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th>Biaya Desain</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detail as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_pesanan }}</td>
                                    <td>{{ $item->nama_barang }}</td>
                                    <td>{{ format_uang($item->harga) }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>{{ format_uang($item->subtotal) }}</td>
                                    <td>{{ format_uang($item->biaya_desain) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-6"></div>
                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            @foreach ($data as $item)
                                <tr>
                                    <td style="width:30%">Total Pesanan</td>
                                    <td>
                                        {{ format_uang($item->total) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30%">Total Biaya Desain</td>
                                    <td>
                                        {{ format_uang($item->total_biaya_desain) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:30%">Grand Total</th>
                                    <td>
                                        {{ format_uang($item->grand_total) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:30%">Bayar</th>
                                    <td>
                                        {{ format_uang($item->bayar) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:30%">Kembali</th>
                                    <td>
                                        {{ format_uang($item->kembali) }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <a href="/pembayaran" class="btn btn-danger btn-sm float-lg-right">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
