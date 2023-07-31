@extends('layout')


@section('content')
    @php
        $nama_level = auth()->user()->level->nama_level;
    @endphp
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Detail Pesanan</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col">
                            <!-- Letakkan elemen lain di sini -->
                            @foreach ($data as $item)
                                @if ($item->status_pesanan == 'Selesai')
                                    @if ($nama_level == 'Administrator' || $nama_level == 'Kasir')
                                        <form method="POST"
                                            action="{{ route('pekerjaan.update_status_diambil_id', $item->id_pesanan) }}"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-info float-right">Tandai
                                                Sudah
                                                Diambil</button>
                                        </form>
                                    @else
                                        <span class="badge badge-secondary float-right">Pesanan Belum Diambil</span>
                                    @endif
                                @elseif($item->status_pesanan == 'Sudah Diambil')
                                    <span class="badge badge-info float-right">Sudah Diambil</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="invoice p-3 mb-3 card-outline card-secondary">
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
                        <tr>
                            <td>Kasir</td>
                            @foreach ($data as $item)
                                <td>: <b>{{ $item->kasir }}</b></td>
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
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Nama Pesanan</th>
                                <th scope="col">Barang</th>
                                <th width="5%">P</th>
                                <th width="5%"">L</th>
                                <th scope="col">QTY</th>
                                <th scope="col">Finishing</th>
                                <th scope="col">Desainer</th>
                                <th scope="col">Operator</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detail as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_pesanan }}</td>
                                    <td>{{ $item->nama_barang }}</td>
                                    <td>{{ $item->panjang }}</td>
                                    <td>{{ $item->lebar }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>{{ $item->nama_finishing }}</td>
                                    <td>{{ $item->desainer }}</td>
                                    <td>{{ $item->operator }}</td>
                                    <td>{{ $item->subtotal }}</td>
                                    <td>
                                        <span
                                            class="badge {{ getStatusColor($item->status_detail) }}">{{ $item->status_detail }}</span>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    <div class="total col-md-6 float-right border-top ">
                        <div class="row ">
                            <div class="col d-flex justify-content-end">
                                <p class="text-bold d-flex align-items-center" style="height:100%;">
                                    TOTAL =</p>
                            </div>
                            <div class="col d-flex justify-content-center">
                                @foreach ($data as $item)
                                    <p id="total" class="text-bold d-flex align-items-center" style="height:100%;">
                                        {{ format_uang($item->total) }}
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-2 float">
                <div class="col-12 ">
                    <a href="javascript:window.history.back()" class="btn btn-sm btn-danger float-right">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
