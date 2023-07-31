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
                                    <td>Hari/Tanggal</td>
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

            <form action="{{ route('pembayaran.store') }}" class="form-pembayaran" method="post">
                @csrf
                <input type="hidden" name="id_pesanan" value="{{ $item->id_pesanan }}">
                <input type="hidden" name="kasir" value="{{ auth()->user()->nama }}">
                <div class="row">
                    <div class="col-6"></div>
                    <div class="col-6">
                        <div class="table-responsive">
                            <table class="table">
                                @foreach ($data as $item)
                                    <tr>
                                        <td style="width:30%">Total Pesanan</td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm" name="total"
                                                id="total" value="{{ $item->total }}" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%">Total Biaya Desain</td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm"
                                                name="total_biaya_desain" id="total_biaya_desain"
                                                value="{{ $item->total_biaya_desain }}" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width:30%">Grand Total</th>
                                        <td>
                                            <input type="number" class="form-control form-control-sm" name="grand_total"
                                                id="grand_total" value="{{ $item->grand_total }}" readonly>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th style="width:30%">Bayar</th>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" name="bayar"
                                            id="bayar" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:30%">Kembali</th>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" name="kembali"
                                            id="kembali" required readonly>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-12">
                    <a href="/pembayaran" class="btn btn-danger btn-sm">Kembali</a>
                    <button type="submit" class="btn btn-success btn-sm float-right btn-simpan">
                        Proses Pembayaran
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#grand_total, #bayar").keyup(function() {
            var bayar = $("#bayar").val();
            var grand_total = $("#grand_total").val();
            var kembali = parseInt(bayar) - parseInt(grand_total);
            $("#kembali").val(kembali);
        })

        $(function() {
            $('.btn-simpan').on('click', function() {
                $('.form-pembayaran').submit();
            });
        });
    </script>
@endsection
