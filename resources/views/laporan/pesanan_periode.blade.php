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
                                            <a href="../pekerjaan/{{ $item->id_pesanan }}/detail"
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
