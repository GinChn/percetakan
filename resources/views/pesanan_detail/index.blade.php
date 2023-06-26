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
  @php
      $total = 0;
  @endphp
  <div class="invoice p-3 mb-3">
    <div class="row">
      <div class="col-12">
        <h4>
          Nota No: {{ $data->no_nota }}
          <small class="float-right">{{ tanggal_indonesia($data->tanggal) }}</small>
        </h4>
      </div>
    </div>
    <div class="row invoice-info" style="margin-bottom: 10px">
      <button onclick="addPesanan('{{ route('pesanan_detail.store') }}')" class="btn btn-success" style="margin-left: 10px">
        Tambah Pesanan
      </button>
    </div>

    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th width="5%">No</th>
              <th>Nama Pesanan</th>
              <th>Barang</th>
              <th>Harga</th>
              <th>Qty</th>
              <th>Subtotal</th>
              <th><i class="fa fa-cog"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($detail as $item)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $item->nama_pesanan }}</td>
              <td>{{ $item->nama_barang }}</td>
              <td>{{ format_uang($item->harga) }}</td>
              <td>{{ $item->jumlah }}</td>
              <td>{{ format_uang($item->subtotal) }}</td>
              <td>
                <button onclick="editDetailPesanan('{{ route('pesanan_detail.update', $item->id_pesanan_detail) }}')" class="btn btn-sm btn-primary">
                  <i class="fas fa-pen"></i>
                </button>
                <form id="hapus-pesanan-detail{{ $item->id_pesanan_detail }}" action="{{ route('pesanan_detail.destroy', $item->id_pesanan_detail) }}" method="post" class="d-inline">
                  @csrf
                  @method('delete')
                  <button type="submit" class="btn btn-sm btn-danger border-0 delete-btn" onclick="deleteDetailPesanan({{ $item->id_pesanan_detail }})">
                      <i class="fa fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
            @php
                $total += $item->harga * $item->jumlah;
            @endphp
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    
    <form action="{{ route('pesanan.store') }}" class="form-pesanan" method="post">
    @csrf
    <input type="hidden" name="id_pesanan" value="{{ $data->id_pesanan }}">
    <div class="row">
      <div class="col-6">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:30%">Nama Pelanggan</th>
              <td>
                <input type="text" class="form-control form-control-sm" name="nama_pelanggan" id="nama_pelanggan" required>
              </td>
            </tr>
            <tr>
              <th style="width:30%">No. Telp</th>
              <td>
                <input type="text" class="form-control form-control-sm" name="no_telp" id="no_telp" required>
              </td>
            </tr>
          </table>
        </div>
      </div>
      
      <div class="col-6">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:30%">Total</th>
              <td>
                <input type="text" class="form-control form-control-sm" name="total" id="total" value="{{ $total }}" required readonly>
              </td>
            </tr>
            <tr>
              <th>Status Desain</th>
              <td>
                <select class="form-control form-control-sm" name="status_desain" id="status_desain">
                  <option value="Belum Selesai">Belum Selesai</option>
                  <option value="Selesai">Selesai</option>
                  {{-- @foreach ($status as $key => $item)
                  <option value="{{ $key }}">{{ $item }}</option>
                  @endforeach --}}
                </select>
              </td>
            </tr>
            <tr>
              <th>Status Pesanan</th>
              <td>
                <select class="form-control form-control-sm" name="status_pesanan" id="status_pesanan">
                  <option value="Belum Selesai">Belum Selesai</option>
                  <option value="Selesai">Selesai</option>
                  {{-- @foreach ($status as $key => $item)
                  <option value="{{ $key }}">{{ $item }}</option>
                  @endforeach --}}
                </select>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </form>
    
    <div class="row">
      <div class="col-12">
        <form id="batal-pesanan{{ $data->id_pesanan }}" action="{{ route('batal.pesanan', $data->id_pesanan) }}" method="post" class="d-inline">
          @csrf
          @method('delete')
          <button type="submit" class="btn btn-danger border-0 delete-btn" onclick="deletePesanan({{ $data->id_pesanan }})">
            Batal
          </button>
        </form>
        <button type="submit" class="btn btn-success float-right btn-simpan"> 
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
  $(function () {
      $('.btn-simpan').on('click', function () {
            $('.form-pesanan').submit();
        });
    });

    function addPesanan(url) {
        $('#modal-pesanan').modal('show');
        $('#modal-pesanan .modal-title').text('Tambah Pesanan');

        $('#modal-pesanan form')[0].reset();
        $('#modal-pesanan form').attr('action', url);
        $('#modal-pesanan [name=_method]').val('post');

        $('#id_barang').select2({
          placeholder: "Pilh Barang",
          width: '100%', 
          dropdownParent: $('#modal-pesanan')
        })

        $(document).on('change', '#id_barang', function(){
          var id_barang = $(this).val()
          $.ajax({
            url : "{{ route('pesanan_detail.barang') }}",
            type : 'get',
            data: { 
              id_barang : id_barang,
              _token : "{{ csrf_token() }}" 
            },
            success: function (res) {
              console.log(res);
              $('#bahan').val(res.id_bahan)
              $('#harga').val(res.harga)
            }
          })
        })

        $(document).on('mouseout', '#jumlah', function() {
          var harga = parseInt($('#harga').val())
          var jumlah = parseInt($(this).val())
          $('#subtotal').val(jumlah * harga)
        })
      }

    function editDetailPesanan(url) {
        $('#modal-pesanan').modal('show');
        $('#modal-pesanan .modal-title').text('Edit Pesanan');

        $('#modal-pesanan form')[0].reset();
        $('#modal-pesanan form').attr('action', url);
        $('#modal-pesanan [name=_method]').val('put');

        $(document).on('change', '#id_barang', function(){
          var id_barang = $(this).val()
          $.ajax({
            url : "{{ route('pesanan_detail.barang') }}",
            type : 'get',
            data: { 
              id_barang : id_barang,
              _token : "{{ csrf_token() }}" 
            },
            success: function (res) {
              console.log(res);
              $('#bahan').val(res.id_bahan)
              $('#harga').val(res.harga)
            }
          })
        })

        $(document).on('mouseout', '#jumlah', function() {
          var harga = parseInt($('#harga').val())
          var jumlah = parseInt($(this).val())
          $('#subtotal').val(jumlah * harga)
        })

        $.get(url)
            .done((response) => {
                $('#modal-pesanan [name=nama_pesanan]').val(response.nama_pesanan);
                $('#modal-pesanan [name=id_barang]').val(response.id_barang);
                $('#modal-pesanan [name=id_bahan]').val(response.id_bahan);
                $('#modal-pesanan [name=harga]').val(response.harga);
                $('#modal-pesanan [name=jumlah]').val(response.jumlah);
                $('#modal-pesanan [name=subtotal]').val(response.subtotal);
            })
        }

        function deleteDetailPesanan(id) {
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
                document.getElementById('hapus-pesanan-detail' + id).submit();
            }
        })
    }

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

<script>
    
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