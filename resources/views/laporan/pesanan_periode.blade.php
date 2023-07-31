@extends('layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Pesanan Lunas</h4>
                    <p class="mt-2">{{ tanggal_indonesia($tanggal) }}</p>
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
                                    <th>No Nota</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Total</th>
                                    <th>Status Pesanan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalPemasukan = 0;
                                @endphp
                                @foreach ($pesanan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->no_nota }}</td>
                                        <td>{{ $item->nama_pelanggan }}</td>
                                        {{-- <td>{{ tanggal_indonesia($item->created_at) }}</td> --}}
                                        <td>{{ format_uang($item->total) }}</td>
                                        <td>
                                            @if ($item->status_pesanan == 'Selesai')
                                                <span class="badge badge-success">
                                                    {{ $item->status_pesanan }}
                                                </span>
                                            @elseif($item->status_pesanan == 'Sudah Diambil')
                                                <span class="badge badge-info">
                                                    {{ $item->status_pesanan }}
                                                </span>
                                            @else
                                                <span class="badge badge-warning">
                                                    {{ $item->status_pesanan }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ $item->id_pesanan }}" class="btn-sm btn-primary">Detail</a>
                                        </td>
                                    </tr>
                                    @php
                                        $totalPemasukan += $item->total;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                    <div class="card-body">
                        <div class="total col-md-6 float-right bg-black ">
                            <div class="row ">
                                <div class="col d-flex justify-content-end">
                                    <p class="text-bold d-flex align-items-center" style="height:100%;">
                                        TOTAL PEMASUKAN =</p>
                                </div>
                                <div class="col d-flex justify-content-center">
                                    <p id="total-pemasukan" class="text-bold d-flex align-items-center"
                                        style="height:100%;">
                                        {{ format_uang($totalPemasukan) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12 ">
                                <a href="javascript:window.history.back()"
                                    class="btn btn-sm btn-danger float-right">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    </div>
@endsection
