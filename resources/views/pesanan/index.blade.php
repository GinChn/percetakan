@extends('layout')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Pesanan</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('pesanan.create') }}" class="btn btn-success">Buat Pesanan</a>
                    {{-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
                        Buat Pesanan
                    </button> --}}
                </div>
                <div class="card-body">
                    <table id="table2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Tanggal</th>
                                <th>No Nota</th>
                                <th>Nama Pelanggan</th>
                                <th>Total</th>
                                <th>Status Desain</th>
                                <th>Status Pesanan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesanan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ tanggal_indonesia($item->tanggal) }}</td>
                                <td>{{ $item->no_nota }}</td>
                                <td>{{ $item->nama_pelanggan }}</td>
                                <td>{{ format_uang($item->total) }}</td>
                                <td>
                                    @if ($item->status_desain == 'Selesai')
                                    <span class="badge badge-success">
                                        {{ $item->status_desain }}
                                    </span>
                                    @else
                                    <span class="badge badge-danger">
                                        {{ $item->status_desain }}
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status_pesanan == 'Selesai')
                                    <span class="badge badge-success">
                                        {{ $item->status_pesanan }}
                                    </span>
                                    @else
                                    <span class="badge badge-danger">
                                        {{ $item->status_pesanan }}
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <form id="hapus-pesanan{{ $item->id_pesanan }}" action="{{ route('pesanan.destroy', $item->id_pesanan) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger border-0 delete-btn" onclick="deletePesanan({{ $item->id_pesanan }})">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- <script>
    function addBahan(url) {
        $('#modal-bahan').modal('show');
        $('#modal-bahan .modal-title').text('Tambah Bahan');

        $('#modal-bahan form')[0].reset();
        $('#modal-bahan form').attr('action', url);
        $('#modal-bahan [name=_method]').val('post');
    }

    function editBahan(url) {
        $('#modal-bahan').modal('show');
        $('#modal-bahan .modal-title').text('Edit Bahan');

        $('#modal-bahan form')[0].reset();
        $('#modal-bahan form').attr('action', url);
        $('#modal-bahan [name=_method]').val('put');

        $.get(url)
            .done((response) => {
                $('#modal-bahan [name=nama_bahan]').val(response.nama_bahan);
            })
    }
</script> --}}

<script>
    function deletePesanan(id) {
        event.preventDefault();
        Swal.fire({
            title: 'Yakin?',
            text: "Hapus data ini",
            icon: 'warning',
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
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
</script>

<script>
    $(function(){
        var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    @if(Session::has('sukses-tambah-bahan'))
    Toast.fire({
            icon: 'success',
            title: '{{ Session::get('sukses-tambah-bahan') }}'
        })
    @endif
    @if(Session::has('sukses-ubah-bahan'))
    Toast.fire({
            icon: 'success',
            title: '{{ Session::get('sukses-ubah-bahan') }}'
        })
    @endif
});
</script>

@endsection