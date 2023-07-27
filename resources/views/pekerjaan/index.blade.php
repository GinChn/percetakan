@extends('layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Status Pekerjaan Pesanan</h4>
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
                                    <th>No</th>
                                    <th>Nota</th>
                                    <th>Tanggal</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Progres Pekerjaan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($progresPesanan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->no_nota }}</td>
                                        <td>{{ tanggal_indonesia($item->created_at) }}</td>
                                        <td>{{ $item->nama_pelanggan }}</td>
                                        <td>
                                            <div class="progress mb-3">
                                                <div class="progress-bar {{ $item->progres < 50 ? 'bg-danger' : ($item->progres == 100 ? 'bg-success' : 'bg-warning') }}"
                                                    role="progressbar" aria-valuenow="{{ $item->progres }}"
                                                    aria-valuemin="0" aria-valuemax="100"
                                                    style="width: {{ $item->progres }}%">
                                                    <span class="sr-only">{{ $item->progres }}% Complete</span>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <a href="/pekerjaan/{{ $item->id_pesanan }}/detail"
                                                class="btn-sm btn-primary">Detail</a>
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
