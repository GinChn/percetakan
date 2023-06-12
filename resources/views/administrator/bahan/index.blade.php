@extends('administrator.layout')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Bahan</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <button onclick="addBahan('{{ route('bahan.store') }}')" class="btn btn-success">
                        Tambah Bahan
                    </button>
                </div>
                <div class="card-body">
                    <table id="table2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>Nama Bahan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bahan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_bahan }}</td>
                                <td>
                                    <button onclick="editBahan('{{ route('bahan.update', $item->id_bahan) }}')" class="btn btn-sm btn-primary">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <form id="hapus-bahan{{ $item->id_bahan }}" action="{{ route('bahan.destroy', $item->id_bahan) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger border-0 delete-btn" onclick="deleteBahan({{ $item->id_bahan }})">
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

@includeIf('administrator.bahan.form-bahan')
@endsection

@section('script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
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
</script>

<script>
    function deleteBahan(id) {
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
                document.getElementById('hapus-bahan' + id).submit();
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