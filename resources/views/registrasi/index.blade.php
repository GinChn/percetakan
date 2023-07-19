@extends('layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Registrasi User</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('registrasi.create') }}" class="btn btn-sm btn-success">
                        Tambah User
                    </a>
                </div>
                <div class="card-body">
                    <table id="table2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>Username</th>
                                <th>Nama Lengkap</th>
                                <th>Level</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->level->nama_level }}</td>
                                <td>
                                    {{-- <button onclick="editBarang('{{ route('barang.update', $item->id_barang) }}')" class="btn btn-sm btn-primary">
                                        <i class="fas fa-pen"></i>
                                    </button> --}}
                                    <form id="hapus-user{{ $item->id_user }}" action="{{ route('registrasi.destroy', $item->id_user) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger border-0 delete-btn" onclick="deleteUser({{ $item->id_user }})">
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
    <script>
        function deleteUser(id) {
        event.preventDefault();
        Swal.fire({
            title: 'Yakin?',
            text: "Untuk menghapus user ini?",
            icon: 'warning',
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('hapus-user' + id).submit();
                Swal.fire(
                'Terhapus!',
                'User berhasil terhapus',
                'success'
                )
            }
        })
    }
    </script>
@endsection