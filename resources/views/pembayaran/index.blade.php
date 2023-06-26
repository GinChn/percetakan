@extends('layout')

@section('content')
<div class="content-header">
  <div class="container-fluid">
      <div class="row mb-2">
          <div class="col-sm-6">
              <h1 class="m-0">Buat Pesanan</h1>
          </div>
      </div>
  </div>
</div>

<div class="container-fluid">
    <div class="invoice p-3 mb-3">
        <!-- title row -->
        <div class="row">
          <div class="col-12">
            <h4>
              Nota No: {{ $data->no_nota }}
              <small class="float-right">{{ tanggal_indonesia($data->created_at) }}</small>
            </h4>
          </div>
          <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info" style="margin-bottom: 10px">
          <button onclick="addPesanan('{{ route('pesanan.store') }}')" class="btn btn-success" style="margin-left: 10px">
            Tambah Pesanan
        </button>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
          <div class="col-12 table-responsive">
            <table class="table table-striped">
              <thead>
              <tr>
                <th width="5%">No</th>
                <th>Nama Pesanan</th>
                <th>Barang</th>
                <th>Bahan</th>
                <th>Harga</th>
                <th>Ukuran</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th><i class="fa fa-cog"></th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td>1</td>
                <td>
                  <input type="text" class="form-control form-control-sm" name="nama_barang" id="nama_barang">
                </td>
                <td>455-981-221</td>
                <td>El snort testosterone trophy driving gloves handsome</td>
                <td>$64.50</td>
                <td>$64.50</td>
                <td>$64.50</td>
                <td>$64.50</td>
                <td>$64.50</td>
              </tr>
              </tbody>
            </table>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <!-- accepted payments column -->
          <div class="col-6">
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th style="width:30%">Subtotal:</th>
                  <td>
                    <input type="text" class="form-control form-control-sm" name="" id="" required>
                  </td>
                </tr>
                <tr>
                  <th>Tax (9.3%)</th>
                  <td>
                    <input type="text" class="form-control form-control-sm" name="" id="" required>
                  </td>
                </tr>
                <th>Tax (9.3%)</th>
                  <td>
                    <input type="text" class="form-control form-control-sm" name="" id="" required>
                  </td>
                </tr>
                <th>Tax (9.3%)</th>
                  <td>
                    <input type="text" class="form-control form-control-sm" name="" id="" required>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-6">
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th style="width:30%">Total</th>
                  <td>
                    <input type="text" class="form-control form-control-sm" name="" id="" required readonly>
                  </td>
                </tr>
                <tr>
                  <th>Bayar</th>
                  <td>
                    <input type="text" class="form-control form-control-sm" name="" id="" required>
                  </td>
                </tr>
                <tr>
                  <th>Kembali</th>
                  <td>
                    <input type="text" class="form-control form-control-sm" name="" id="" required readonly>
                  </td>
                </tr>
                <tr>
                  <th>Status Desain</th>
                  <td>
                    <input type="text" class="form-control form-control-sm" name="" id="" required>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row">
          <div class="col-12">
            <form id="batal-pesanan{{ $data->id_pesanan }}" action="{{ route('pesanan_detail.destroy', $data->id_pesanan) }}" method="post" class="d-inline">
              @csrf
              @method('delete')
              <button type="submit" class="btn btn-danger border-0 delete-btn" onclick="deletePesanan({{ $data->id_pesanan }})">
                  Batal
              </button>
          </form>
            {{-- <a href="/pesanan" class="btn btn-danger">Batal</a> --}}
            <button type="button" class="btn btn-success float-right"> 
              Simpan Pesanan
            </button>
          </div>
        </div>
      </div>
</div>

@includeIf('pesanan_detail.form-pesanan')
@endsection

@section('script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function addPesanan(url) {
        $('#modal-pesanan').modal('show');
        $('#modal-pesanan .modal-title').text('Tambah pesanan');

        $('#modal-pesanan form')[0].reset();
        $('#modal-pesanan form').attr('action', url);
        $('#modal-pesanan [name=_method]').val('post');
    }

    function editpesanan(url) {
        $('#modal-pesanan').modal('show');
        $('#modal-pesanan .modal-title').text('Edit pesanan');

        $('#modal-pesanan form')[0].reset();
        $('#modal-pesanan form').attr('action', url);
        $('#modal-pesanan [name=_method]').val('put');

        $.get(url)
            .done((response) => {
                $('#modal-pesanan [name=nama_pesanan]').val(response.nama_pesanan);
                $('#modal-pesanan [name=id_bahan]').val(response.id_bahan);
                $('#modal-pesanan [name=id_mesin]').val(response.id_mesin);
                $('#modal-pesanan [name=id_satuan]').val(response.id_satuan);
                $('#modal-pesanan [name=harga]').val(response.harga);
            })
    }
</script>

<script>
    function deletePesanan(id) {
        event.preventDefault();
        Swal.fire({
            title: 'Yakin?',
            text: "Untuk Membatalkan Pesanan",
            icon: 'warning',
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('batal-pesanan' + id).submit();
            }
        })
    }
</script>

{{-- <script>
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
</script> --}}
@endsection