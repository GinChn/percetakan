@extends('administrator.layout')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Pengeluaran</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <button onclick="addPengeluaran('{{ route('pengeluaran.store') }}')" class="btn btn-success">
                        Tambah Pengeluaran
                    </button>
                </div>
                <div class="card-body">
                    <table id="table2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>Keterangan</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengeluaran as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td>{{ format_uang($item->harga) }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ format_uang($item->total) }}</td>
                                <td>
                                    <button onclick="editPengeluaran('{{ route('pengeluaran.update', $item->id_pengeluaran) }}')" class="btn btn-sm btn-primary">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <form id="hapus-pengeluaran{{ $item->id_pengeluaran }}" action="{{ route('pengeluaran.destroy', $item->id_pengeluaran) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger border-0 delete-btn" onclick="deletePengeluaran({{ $item->id_pengeluaran }})">
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

@includeIf('administrator.pengeluaran.form-pengeluaran')
@endsection

@section('script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function addPengeluaran(url) {
        $('#modal-pengeluaran').modal('show');
        $('#modal-pengeluaran .modal-title').text('Tambah Pengeluaran');

        $('#modal-pengeluaran form')[0].reset();
        $('#modal-pengeluaran form').attr('action', url);
        $('#modal-pengeluaran [name=_method]').val('post');

        $("#harga, #jumlah").keyup(function() {
            var harga = $("#harga").val();
            var jumlah = $("#jumlah").val();
            var total = parseInt(harga) * parseInt(jumlah);
            $("#total").val(total);
        })
    }

    function editPengeluaran(url) {
        $('#modal-pengeluaran').modal('show');
        $('#modal-pengeluaran .modal-title').text('Edit Pengeluaran');

        $('#modal-pengeluaran form')[0].reset();
        $('#modal-pengeluaran form').attr('action', url);
        $('#modal-pengeluaran [name=_method]').val('put');
        
        $("#harga, #jumlah").keyup(function() {
            var harga = $("#harga").val();
            var jumlah = $("#jumlah").val();
            var total = parseInt(harga) * parseInt(jumlah);
            $("#total").val(total);
        })

        $.get(url)
            .done((response) => {
                $('#modal-pengeluaran [name=keterangan]').val(response.keterangan);
                $('#modal-pengeluaran [name=jumlah]').val(response.jumlah);
                $('#modal-pengeluaran [name=harga]').val(response.harga);
                $('#modal-pengeluaran [name=total]').val(response.total);
            })
    }
</script>

<script>
    $(document).ready(function() {
        $("#harga, #jumlah").keyup(function() {
            var harga = $("#harga").val();
            var jumlah = $("jumlah").val();
            var total = parseInt(harga) * parseInt(jumlah);
            $("#total").val(total);
        })
    })
</script>

<script>
    function deletePengeluaran(id) {
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
                document.getElementById('hapus-pengeluaran' + id).submit();
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
    @if(Session::has('sukses-tambah-pengeluaran'))
    Toast.fire({
            icon: 'success',
            title: '{{ Session::get('sukses-tambah-pengeluaran') }}'
        })
    @endif
    @if(Session::has('sukses-ubah-pengeluaran'))
    Toast.fire({
            icon: 'success',
            title: '{{ Session::get('sukses-ubah-pengeluaran') }}'
        })
    @endif
});
</script>

@endsection