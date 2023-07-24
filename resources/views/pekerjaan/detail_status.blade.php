@extends('layout')


@section('content')
    @php
        $nama_level = auth()->user()->level->nama_level;
    @endphp
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Detail Status Pesanan</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
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
                                <th scope="col">Jenis Barang</th>
                                <th width="5%">Panjang</th>
                                <th width="5%"">Lebar</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Finishing</th>
                                <th scope="col">Status</th>
                                @if ($nama_level == 'Administrator' || $nama_level == 'Desainer' || $nama_level == 'Operator')
                                    <th scope="col">Ubah Status</th>
                                @endif
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
                                    <td>
                                        <span
                                            class="badge {{ getStatusColor($item->status_detail) }}">{{ $item->status_detail }}</span>
                                    </td>
                                    @if ($nama_level == 'Administrator' || $nama_level == 'Desainer' || $nama_level == 'Operator')
                                        <td>



                                            @php
                                                $status_detail = $item->status_detail;
                                                $nama_level = auth()->user()->level->nama_level;
                                            @endphp

                                            @if ($nama_level === 'Desainer')
                                                {{-- Button for status_detail = 1 --}}
                                                <form action="/pekerjaan/{{ $item->id_pesanan_detail }}/update-status"
                                                    method="post" class="d-inline-block">
                                                    @csrf
                                                    <input type="hidden" name="status_detail" value="1">
                                                    @if ($status_detail === 'Sudah Ada Desain')
                                                        <button type="submit" class="btn btn-sm btn-secondary my-1">
                                                            <i class="fas fa-undo"></i>
                                                        </button>
                                                    @endif
                                                </form>

                                                {{-- Button for status_detail = 2 --}}
                                                <form action="/pekerjaan/{{ $item->id_pesanan_detail }}/update-status"
                                                    method="post" class="d-inline-block">
                                                    @csrf
                                                    <input type="hidden" name="status_detail" value="2">
                                                    @if ($status_detail === 'Belum Ada Desain')
                                                        <button type="submit" class="btn btn-sm btn-success my-1">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    @endif
                                                </form>
                                            @endif

                                            @if ($nama_level === 'Operator')
                                                {{-- Button for status_detail = 2 --}}
                                                <form action="/pekerjaan/{{ $item->id_pesanan_detail }}/update-status"
                                                    method="post" class="d-inline-block">
                                                    @csrf
                                                    <input type="hidden" name="status_detail" value="2">
                                                    @if ($status_detail == 'Dikerjakan')
                                                        <button type="submit" class="btn btn-sm btn-secondary my-1">
                                                            <i class="fas fa-undo"></i>
                                                        </button>
                                                    @endif
                                                </form>

                                                {{-- Button for status_detail = 3 --}}
                                                <form action="/pekerjaan/{{ $item->id_pesanan_detail }}/update-status"
                                                    method="post" class="d-inline-block">
                                                    @csrf
                                                    <input type="hidden" name="status_detail" value="3">
                                                    @if ($status_detail === 'Sudah Ada Desain')
                                                        <button type="submit" class="btn btn-sm btn-success my-1">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    @elseif ($status_detail == 'Selesai')
                                                        <button type="submit" class="btn btn-sm btn-secondary my-1">
                                                            <i class="fas fa-undo"></i>
                                                        </button>
                                                    @endif
                                                </form>

                                                {{-- Button for status_detail = 4 --}}
                                                <form action="/pekerjaan/{{ $item->id_pesanan_detail }}/update-status"
                                                    method="post" class="d-inline-block">
                                                    @csrf
                                                    <input type="hidden" name="status_detail" value="4">
                                                    @if ($status_detail === 'Dikerjakan')
                                                        <button type="submit" class="btn btn-sm btn-success my-1">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    @endif
                                                </form>
                                            @endif

                                            @if ($nama_level == 'Administrator')
                                                <button type="button"
                                                    class="btn btn-default btn-sm dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    @php
                                                        $status_detail = $item->status_detail;
                                                    @endphp

                                                    <form action="/pekerjaan/{{ $item->id_pesanan_detail }}/update-status"
                                                        method="post">
                                                        @csrf
                                                        <input type="hidden" name="status_detail" value="1">
                                                        @if ($status_detail !== 'Belum Ada Desain')
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-edit text-danger"></i> Belum Ada Desain
                                                            </button>
                                                        @endif
                                                    </form>

                                                    <form action="/pekerjaan/{{ $item->id_pesanan_detail }}/update-status"
                                                        method="post">
                                                        @csrf
                                                        <input type="hidden" name="status_detail" value="2">
                                                        @if ($status_detail !== 'Sudah Ada Desain')
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-edit text-warning"></i> Sudah Ada Desain
                                                            </button>
                                                        @endif
                                                    </form>

                                                    <form action="/pekerjaan/{{ $item->id_pesanan_detail }}/update-status"
                                                        method="post">
                                                        @csrf
                                                        <input type="hidden" name="status_detail" value="3">
                                                        @if ($status_detail !== 'Dikerjakan')
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-edit text-info"></i> Dikerjakan
                                                            </button>
                                                        @endif
                                                    </form>

                                                    <form action="/pekerjaan/{{ $item->id_pesanan_detail }}/update-status"
                                                        method="post">
                                                        @csrf
                                                        <input type="hidden" name="status_detail" value="4">
                                                        @if ($status_detail !== 'Selesai')
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-edit text-success"></i> Selesai
                                                            </button>
                                                        @endif
                                                    </form>
                                                </div>
                                            @endif

                                        </td>
                                    @endif
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

                        </table>
                    </div>
                </div>
            </div>

            {{-- <div class="row">
                <div class="col-12">
                    <a href="/pembayaran" class="btn btn-danger btn-sm">Kembali</a>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
