@extends('layout')

@section('content')
    @php
        $nama_level = auth()->user()->level->nama_level;
    @endphp
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Mesin</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @if ($nama_level == 'Administrator')
                        <div class="card-header">
                            <button onclick="addMesin('{{ route('mesin.store') }}')" class="btn btn-sm btn-success">
                                Tambah Mesin
                            </button>
                        </div>
                    @endif
                    <div class="card-body">
                        <table id="table2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">No</th>
                                    <th>Jenis Mesin</th>

                                    @if ($nama_level == 'Administrator')
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mesin as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->jenis_mesin }}</td>
                                        @if ($nama_level == 'Administrator')
                                            <td>
                                                <button onclick="editMesin('{{ route('mesin.update', $item->id_mesin) }}')"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                <form id="hapus-mesin{{ $item->id_mesin }}"
                                                    action="{{ route('mesin.destroy', $item->id_mesin) }}" method="post"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm btn-danger border-0 delete-btn"
                                                        onclick="deleteMesin({{ $item->id_mesin }})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @includeIf('mesin.form-mesin')
@endsection

@section('script')
    <script>
        function addMesin(url) {
            $('#modal-mesin').modal('show');
            $('#modal-mesin .modal-title').text('Tambah Mesin');

            $('#modal-mesin form')[0].reset();
            $('#modal-mesin form').attr('action', url);
            $('#modal-mesin [name=_method]').val('post');
        }

        function editMesin(url) {
            $('#modal-mesin').modal('show');
            $('#modal-mesin .modal-title').text('Edit Mesin');

            $('#modal-mesin form')[0].reset();
            $('#modal-mesin form').attr('action', url);
            $('#modal-mesin [name=_method]').val('put');

            $.get(url)
                .done((response) => {
                    $('#modal-mesin [name=jenis_mesin]').val(response.jenis_mesin);
                })
        }

        function deleteMesin(id) {
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
                    document.getElementById('hapus-mesin' + id).submit();
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
            @if (Session::has('sukses-tambah-mesin'))
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('sukses-tambah-mesin') }}'
                })
            @endif
            @if (Session::has('sukses-ubah-mesin'))
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('sukses-ubah-mesin') }}'
                })
            @endif
        });
    </script>
@endsection
