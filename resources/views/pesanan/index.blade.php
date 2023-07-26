@extends('layout')

@section('content')
    @php
        $nama_level = auth()->user()->level->nama_level;
    @endphp
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pesanan</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if ($nama_level == 'Administrator' || $nama_level == 'Desainer')
                        <div class="card-header">
                            <a href="{{ route('pesanan.create') }}" class="btn btn-success btn-sm">Buat Pesanan</a>
                        </div>
                    @endif
                    <div class="card-body">
                        <table id="table2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>No Nota</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Pesanan</th>
                                    <th>Pembayaran</th>
                                    @if ($nama_level == 'Administrator' || $nama_level == 'Desainer')
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pesanan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->no_nota }}</td>
                                        <td>{{ $item->nama_pelanggan }}</td>
                                        <td>{{ tanggal_indonesia($item->created_at) }}</td>
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
                                            @if ($item->status_pembayaran == 'Lunas')
                                                <span class="badge badge-success">
                                                    {{ $item->status_pembayaran }}
                                                </span>
                                            @else
                                                <span class="badge badge-danger">
                                                    {{ $item->status_pembayaran }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($nama_level == 'Administrator' || ($nama_level == 'Desainer' && $item->status_pembayaran != 'Lunas'))
                                                <form id="hapus-pesanan{{ $item->id_pesanan }}"
                                                    action="{{ route('pesanan.destroy', $item->id_pesanan) }}"
                                                    method="post" class="d-inline-block">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm btn-danger border-0 delete-btn"
                                                        onclick="deletePesanan({{ $item->id_pesanan }})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="/pekerjaan/{{ $item->id_pesanan }}/detail"
                                                class="btn btn-default btn-sm"><i class="fas fa-list"></i></a>
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

@section('script')
    <script>
        function deletePesanan(id) {
            event.preventDefault();
            Swal.fire({
                title: 'Yakin?',
                text: "Hapus data pesanan ini?",
                icon: 'warning',
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('hapus-pesanan' + id).submit();
                    Swal.fire(
                        'Terhapus!',
                        'Data berhasil terhapus',
                        'success'
                    )
                }
            })
        }

        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            @if (Session::has('sukses-tambah-bahan'))
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('sukses-tambah-bahan') }}'
                })
            @endif
            @if (Session::has('sukses-ubah-bahan'))
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('sukses-ubah-bahan') }}'
                })
            @endif
        });
    </script>
@endsection
