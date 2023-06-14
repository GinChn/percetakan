@extends('layout')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Barang</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <button onclick="addBarang('{{ route('barang.store') }}')" class="btn btn-success">
                        Tambah Barang
                    </button>
                </div>
                <div class="card-body">
                    <table id="table2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>Nama Barang</th>
                                <th>Jenis Bahan</th>
                                <th>Jenis Mesin</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barang as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->bahan->nama_bahan }}</td>
                                <td>{{ $item->mesin->jenis_mesin }}</td>
                                <td>{{ $item->satuan->nama_satuan }}</td>
                                <td>{{ format_uang($item->harga) }}</td>
                                <td>
                                    <button onclick="editBarang('{{ route('barang.update', $item->id_barang) }}')" class="btn btn-sm btn-primary">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <form id="hapus-barang{{ $item->id_barang }}" action="{{ route('barang.destroy', $item->id_barang) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger border-0 delete-btn" onclick="deleteBarang({{ $item->id_barang }})">
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

@includeIf('barang.form-barang')
@endsection

@section('script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function addBarang(url) {
        $('#modal-barang').modal('show');
        $('#modal-barang .modal-title').text('Tambah barang');

        $('#modal-barang form')[0].reset();
        $('#modal-barang form').attr('action', url);
        $('#modal-barang [name=_method]').val('post');
    }

    function editBarang(url) {
        $('#modal-barang').modal('show');
        $('#modal-barang .modal-title').text('Edit barang');

        $('#modal-barang form')[0].reset();
        $('#modal-barang form').attr('action', url);
        $('#modal-barang [name=_method]').val('put');

        $.get(url)
            .done((response) => {
                $('#modal-barang [name=nama_barang]').val(response.nama_barang);
                $('#modal-barang [name=id_bahan]').val(response.id_bahan);
                $('#modal-barang [name=id_mesin]').val(response.id_mesin);
                $('#modal-barang [name=id_satuan]').val(response.id_satuan);
                $('#modal-barang [name=harga]').val(response.harga);
            })
    }
</script>

<script>
    function deleteBarang(id) {
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
                document.getElementById('hapus-barang' + id).submit();
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
    @if(Session::has('sukses-tambah-barang'))
    Toast.fire({
            icon: 'success',
            title: '{{ Session::get('sukses-tambah-barang') }}'
        })
    @endif
    @if(Session::has('sukses-ubah-barang'))
    Toast.fire({
            icon: 'success',
            title: '{{ Session::get('sukses-ubah-barang') }}'
        })
    @endif
});
</script>
@endsection