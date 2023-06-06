@extends('administrator.layout')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Produk</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah-produk">
                        Tambah Produk
                    </button>
                </div>
                <div class="card-body">
                    <table id="table2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Jenis Bahan</th>
                                <th>Jenis Mesin</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produk as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_produk }}</td>
                                <td>{{ $item->jenis_bahan }}</td>
                                <td>{{ $item->kategori->jenis_mesin }}</td>
                                <td>{{ $item->satuan->nama_satuan }}</td>
                                <td>{{ $item->harga }}</td>
                                <td>
                                    <a href="/produk/{{ $item->id_produk }}/edit" class="btn-sm btn-primary"><i class="fas fa-pen"></i></a>
                                    <form id="hapus-produk{{ $item->id_produk }}" action="{{ route('produk.destroy', $item->id_produk) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn-sm btn-danger border-0 delete-btn" onclick="deleteProduk({{ $item->id_produk }})">
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

@includeIf('administrator.produk.create')
@endsection

@section('script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(function(e){
        
    });
</script>

<script>
    function deleteProduk(id) {
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
                document.getElementById('hapus-produk' + id).submit();
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
    @if(Session::has('sukses-tambah'))
    Toast.fire({
            icon: 'success',
            title: '{{ Session::get('sukses-tambah') }}'
        })
    @endif
    @if(Session::has('gagal-tambah'))
    Toast.fire({
            icon: 'error',
            title: '{{ Session::get('gagal-tambah') }}'
        })
    @endif
});
</script>

<script>
    $(function(){
        var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    @if(Session::has('sukses-ubah'))
    Toast.fire({
            icon: 'success',
            title: '{{ Session::get('sukses-ubah') }}'
        })
    @endif
    @if(Session::has('gagal-ubah'))
    Toast.fire({
            icon: 'error',
            title: '{{ Session::get('gagal-ubah') }}'
        })
    @endif
});
</script>
@endsection