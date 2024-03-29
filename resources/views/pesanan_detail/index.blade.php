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
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title">Input Pesanan</h3>
                    </div>
                    <form action="{{ route('pesanan_detail.store') }}" method="post" class="form-inputPesanan">
                        @csrf
                        @method('post')
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" class="form-control" name="id_pesanan" id="id_pesanan"
                                    value="{{ $data->id_pesanan }}">
                                <input type="hidden" class="form-control form-control-sm" id="desainer" name="desainer"
                                    value="{{ auth()->user()->nama }}">
                                <input type="hidden" class="form-control form-control-sm" id="totalharga"
                                    name="totalharga">
                                <input type="hidden" class="form-control form-control-sm" id="totalukuran"
                                    name="totalukuran">
                                <input type="hidden" class="form-control form-control-sm" id="satuan" name="satuan">
                                <input type="hidden" class="form-control" name="id_bahan" id="id_bahan">
                                <div class="col-6" style="padding: 5px 40px">
                                    <div class="form-group row">
                                        <label for="no_nota" class="col-sm-3 col-form-label" style="font-size: 11pt">No
                                            Nota</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="no_nota"
                                                name="no_nota" value="{{ $data->no_nota }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nama_pesanan" class="col-sm-3 col-form-label"
                                            style="font-size: 11pt">Nama Pesanan</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="nama_pesanan"
                                                name="nama_pesanan" placeholder="Masukkan Nama Pesanan" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="id_barang" class="col-sm-3 col-form-label"
                                            style="font-size: 11pt">Barang</label>
                                        <div class="col-sm-8">
                                            <select class="form-control form-control-sm" id="id_barang" name="id_barang">
                                                <option>Pilih Barang</option>
                                                @foreach ($barang as $item)
                                                    <option value="{{ $item->id_barang }}">{{ $item->nama_barang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="harga" class="col-sm-3 col-form-label"
                                            style="font-size: 11pt">Harga</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control form-control-sm" id="harga"
                                                name="harga" readonly required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6" style="padding: 5px 40px">
                                    <div class="form-group row ukuran" id="ukuran">
                                        <label for="ukuran" class="col-sm-3 col-form-label ukuran" style="font-size: 11pt"
                                            id="ukuran">Ukuran</label>
                                        <div class="col-sm-4 panjang">
                                            <input type="number" class="form-control form-control-sm" id="panjang"
                                                name="panjang" placeholder="Panjang">
                                        </div>
                                        <div class="col-sm-4 lebar">
                                            <input type="number" class="form-control form-control-sm" id="lebar"
                                                name="lebar" placeholder="Lebar">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="jumlah" class="col-sm-3 col-form-label"
                                            style="font-size: 11pt">Qty</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control form-control-sm" id="jumlah"
                                                name="jumlah" placeholder="Masukkan Jumlah" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subtotal" class="col-sm-3 col-form-label"
                                            style="font-size: 11pt">Subtotal</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control form-control-sm" id="subtotal"
                                                name="subtotal" placeholder="Subtotal" readonly required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="finishing" class="col-sm-3 col-form-label"
                                            style="font-size: 11pt">Finishing</label>
                                        <div class="col-sm-8">
                                            <select class="form-control form-control-sm" id="id_finishing"
                                                name="id_finishing">
                                                @foreach ($finishing as $item)
                                                    <option value="{{ $item->id_finishing }}">{{ $item->nama_finishing }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="status_detail" class="col-sm-3 col-form-label"
                                            style="font-size: 11pt">Status</label>
                                        <div class="col-sm-8">
                                            <select class="form-control form-control-sm" name="status_detail"
                                                id="status_detail">
                                                <option value="Belum Ada Desain">Belum Ada Desain</option>
                                                <option value="Sudah Ada Desain">Sudah Ada Desain</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row biaya-desain-group">
                                        <!-- Tambahkan kelas "biaya-desain-group" di sini -->
                                        <label for="biaya_desain" class="col-sm-3 col-form-label"
                                            style="font-size: 11pt">Biaya Desain</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control form-control-sm" id="biaya_desain"
                                                name="biaya_desain">
                                        </div>
                                    </div>

                                </div>
                            </div>
                    </form>
                    <div>
                        <form id="batal-pesanan{{ $data->id_pesanan }}"
                            action="{{ route('batal.pesanan', $data->id_pesanan) }}" method="post" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm border-0 delete-btn"
                                onclick="deletePesanan({{ $data->id_pesanan }})">
                                Kembali
                            </button>
                        </form>
                        <button type="submit"
                            class="btn btn-success btn-sm float-right btn-inputPesanan">Tambahkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $total = 0;
        $total_biaya_desain = 0;
        $grand_total = 0;
    @endphp
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Detail Pesanan</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Pesanan</th>
                                <th>Barang</th>
                                <th>Ukuran</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th>Status</th>
                                <th>Biaya Desain</th>
                                <th width="10%"><i class="fa fa-cog"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detail as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_pesanan }}</td>
                                    <td>{{ $item->nama_barang }}</td>
                                    @if ($item->satuan == 'Meter')
                                        <td>{{ $item->panjang }} x {{ $item->lebar }} m </td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td>{{ format_uang($item->harga) }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>{{ format_uang($item->subtotal) }}</td>
                                    <td>
                                        @if ($item->status_detail == 'Belum Ada Desain')
                                            <span class="badge badge-danger">
                                                {{ $item->status_detail }}
                                            </span>
                                        @elseif ($item->status_detail == 'Sudah Ada Desain')
                                            <span class="badge badge-warning">
                                                {{ $item->status_detail }}
                                            </span>
                                        @elseif ($item->status_detail == 'Dikerjakan')
                                            <span class="badge badge-info">
                                                {{ $item->status_detail }}
                                            </span>
                                        @else
                                            <span class="badge badge-success">
                                                {{ $item->status_detail }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ format_uang($item->biaya_desain) }}</td>
                                    <td>
                                        <button
                                            onclick="editDetailPesanan('{{ route('pesanan_detail.update', $item->id_pesanan_detail) }}')"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <form id="hapus-pesanan-detail{{ $item->id_pesanan_detail }}"
                                            action="{{ route('pesanan_detail.destroy', $item->id_pesanan_detail) }}"
                                            method="post" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger border-0 delete-btn"
                                                onclick="deleteDetailPesanan({{ $item->id_pesanan_detail }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @php
                                    $total += $item->subtotal;
                                    $total_biaya_desain += $item->biaya_desain;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <form action="{{ route('pesanan.store') }}" class="form-simpanPesanan" method="post">
                    @csrf
                    <input type="hidden" name="id_pesanan" value="{{ $data->id_pesanan }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6" style="margin-left: 50%">
                                <table class="table">
                                    <tr>
                                        <th style="width:30%">Total Pesanan</th>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" name="total"
                                                id="total" value="{{ $total }}" required readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width:30%">Total Biaya Desain</th>
                                        <td>
                                            <input type="number" class="form-control form-control-sm"
                                                name="total_biaya_desain" value="{{ $total_biaya_desain }}"
                                                id="total_biaya_desain" required readonly>
                                        </td>
                                    </tr>
                                    @php
                                        $grand_total = $total + $total_biaya_desain;
                                    @endphp
                                    <tr>
                                        <th style="width:30%">Grand Total</th>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" name="grand_total"
                                                id="grand_total" value="{{ $grand_total }}" required readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width:30%">Pelanggan</th>
                                        <td>
                                            <input type="text" class="form-control form-control-sm"
                                                name="nama_pelanggan" id="nama_pelanggan" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width:30%">No. Telp</th>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" name="no_telp"
                                                id="no_telp" required>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div>
                            <button type="submit"
                                class="btn btn-success btn-sm float-right btn-simpanPesanan">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    @includeIf('pesanan_detail.form-pesanan')
@endsection

@section('script')
    {{-- script input pesanan --}}
    <script>
        // Menggunakan Select2 untuk pilih barang
        $(function() {
            $('#id_barang').select2({
                theme: 'bootstrap4'
            })
        })

        $(function() {
            $('#ukuran').hide()
        });

        // Ketika barang dipilih otomatis mengisi field harga yang diambil dari database
        $(document).on('change', '#id_barang', function() {
            var id_barang = $(this).val()
            $.ajax({
                url: "{{ route('pesanan_detail.barang') }}",
                type: 'get',
                data: {
                    id_barang: id_barang,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    console.log(res);
                    $('#id_bahan').val(res.id_bahan)
                    $('#harga').val(res.harga)
                    $('#satuan').val(res.satuan)
                }
            })
        });

        $(document).on('mouseout', '#jumlah, #id_barang', function() {
            var satuan = $('#satuan').val()
            if (satuan === 'Meter') {
                $('#ukuran').show()
                //ambil data dari inputan harga
                var harga = parseInt($('#harga').val())
                //ambil nilai panjang dan lebar yang diinputkan
                var panjang = $('#panjang').val()
                var lebar = $('#lebar').val()
                //hitung jumlah dari perkalian panjang dan lebar dan simpan ke variabel ukuran
                var ukuran = panjang * lebar
                //hitung total harga berdasarkan perhitungan yang diambil dari data variabel ukuran dan harga
                var totalharga = ukuran * harga
                //ambil data inputan jumlah
                var jumlah = $(this).val()
                //menampilkan subtotal berdasarkan perhitungan yang diambil dari data variabel totalharga dan jumlah
                $('#totalukuran').val(ukuran * jumlah)
                $('#totalharga').val(totalharga)
                $('#subtotal').val(totalharga * jumlah)
            } else {
                $('#ukuran').hide()
                var harga = parseInt($('#harga').val())
                var jumlah = parseInt($(this).val())
                $('#totalharga').val(harga)
                $('#subtotal').val(jumlah * harga)
            }
        });

        // Fungsi untuk menyimpan input pesanan saat klik tombol tambahkan
        $(function() {
            $('.btn-inputPesanan').on('click', function() {
                $('.form-inputPesanan').submit();
            });
        });

        // Alert berhasil input pesanan
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            @if (Session::has('sukses-input-pesanan'))
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('sukses-input-pesanan') }}'
                })
            @endif
        });

        // Fungsi untuk membatalkan pesanan ketika klik tombol batal
        function deletePesanan(id) {
            event.preventDefault();
            Swal.fire({
                title: 'Anda Yakin?',
                text: "Untuk membatalkan pesanan",
                icon: 'warning',
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('batal-pesanan' + id).submit();
                }
            })
        }
    </script>

    {{-- script detail pesanan --}}
    <script>
        // Menampilkan form edit pesanan
        function editDetailPesanan(url) {
            $('#modal-pesanan').modal('show');
            $('#modal-pesanan .modal-title').text('Edit Pesanan');
            $('#modal-pesanan form')[0].reset();
            $('#modal-pesanan form').attr('action', url);
            $('#modal-pesanan [name=_method]').val('put');

            $('#modal-pesanan').on('change', '#barang', function() {
                var id_barang = $(this).val()
                $.ajax({
                    url: "{{ route('pesanan_detail.barang') }}",
                    type: 'get',
                    data: {
                        id_barang: id_barang,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        console.log(res);
                        $('#bahan').val(res.id_bahan)
                        $('#harga_detail').val(res.harga)
                        $('#satuan_detail').val(res.satuan)
                    }
                })
            })

            $('#modal-pesanan').on('mouseout', '#jumlah_detail, #barang', function() {
                var satuan = $('#satuan_detail').val()
                if (satuan === 'Meter') {
                    $('#detail-ukuran').show()
                    //ambil data dari inputan harga
                    var harga = parseInt($('#harga_detail').val())
                    //ambil nilai panjang dan lebar yang diinputkan
                    var panjang = $('#panjang_detail').val()
                    var lebar = $('#lebar_detail').val()
                    //hitung jumlah dari perkalian panjang dan lebar dan simpan ke variabel ukuran
                    var ukuran = panjang * lebar
                    //hitung total harga berdasarkan perhitungan yang diambil dari data variabel ukuran dan harga
                    var totalharga = ukuran * harga
                    //ambil data inputan jumlah
                    var jumlah = $(this).val()
                    //menampilkan subtotal berdasarkan perhitungan yang diambil dari data variabel totalharga dan jumlah
                    $('#totalukuran_detail').val(ukuran * jumlah)
                    $('#totalharga_detail').val(totalharga)
                    $('#subtotal_detail').val(totalharga * jumlah)
                } else {
                    $('#detail-ukuran').hide()
                    var harga = parseInt($('#harga_detail').val())
                    var jumlah = parseInt($(this).val())
                    $('#totalharga_detail').val(harga)
                    $('#subtotal_detail').val(jumlah * harga)
                }
            });

            $.get(url)
                .done((response) => {
                    $('#modal-pesanan [name=nama_pesanan]').val(response.nama_pesanan);
                    $('#modal-pesanan [name=id_barang]').val(response.id_barang);
                    $('#modal-pesanan [name=id_bahan]').val(response.id_bahan);
                    $('#modal-pesanan [name=panjang]').val(response.panjang);
                    $('#modal-pesanan [name=lebar]').val(response.lebar);
                    $('#modal-pesanan [name=harga]').val(response.harga);
                    $('#modal-pesanan [name=jumlah]').val(response.jumlah);
                    $('#modal-pesanan [name=subtotal]').val(response.subtotal);
                    $('#modal-pesanan [name=id_finishing]').val(response.id_finishing);
                    $('#modal-pesanan [name=status_detail]').val(response.status_detail);
                    $('#modal-pesanan [name=satuan]').val(response.satuan);
                    $('#modal-pesanan [name=biaya_desain]').val(response.biaya_desain);
                })
        }

        // Alert berhasil edit pesanan
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            @if (Session::has('sukses-edit-pesanan'))
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('sukses-edit-pesanan') }}'
                })
            @endif
        });

        // Hapus detail pesanan yang dipilih
        function deleteDetailPesanan(id) {
            event.preventDefault();
            Swal.fire({
                title: 'Anda Yakin?',
                text: "Ingin menghapus item pesanan ini?",
                icon: 'warning',
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('hapus-pesanan-detail' + id).submit();
                }
            })
        }

        // Fungsi untuk menyimpan detail pesanan saat klik tombol simpan
        $(function() {
            $('.btn-simpanPesanan').on('click', function() {
                $('.form-simpanPesanan').submit();
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const statusDropdown = document.getElementById("status_detail");
            const biayaDesainInputGroup = document.querySelector(".form-group.biaya-desain-group");

            // Fungsi untuk menampilkan/menghilangkan input biaya desain berdasarkan pilihan "Status"
            function toggleBiayaDesainInput() {
                if (statusDropdown.value === "Belum Ada Desain") {
                    biayaDesainInputGroup.classList.remove("d-none");
                } else {
                    biayaDesainInputGroup.classList.add("d-none");
                    document.getElementById("biaya_desain").value =
                        "0"; // Set nilai input menjadi 0 jika sudah ada desain
                }
            }

            // Panggil fungsi pertama kali untuk inisialisasi tampilan awal
            toggleBiayaDesainInput();

            // Tambahkan event listener untuk mengubah tampilan ketika pilihan "Status" berubah
            statusDropdown.addEventListener("change", toggleBiayaDesainInput);
        });
    </script>
@endsection
