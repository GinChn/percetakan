@extends('layout')

@section('content')
    @php
        $nama_level = auth()->user()->level->nama_level;
    @endphp
    <link rel="stylesheet" href="{{ asset('assets/dist/css/custom/checkbox.css') }}">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Belum Ada Desain</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        @if ($nama_level == 'Administrator' || $nama_level == 'Desainer')
            <div class="row mb-4">
                <div class="col-12">

                    <div class="col-auto float-right" id="ubahButton">
                        <button class="btn btn-sm btn-warning">Ubah</button>
                    </div>
                    <div class="col-auto float-right" id="okButton">
                        <button class="btn btn-sm btn-success">OK</button>
                    </div>
                    <div class="col-auto float-right" id="batalButton">
                        <button class="btn btn-sm btn-danger">Batal</button>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <table id="table2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nota</th>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    <th>Pesanan</th>
                                    <th>Barang</th>
                                    <th>P</th>
                                    <th>L</th>
                                    <th>QTY</th>
                                    <th>Finishing</th>
                                    <th class="pilih-check hide-on-start">Pilih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->no_nota }}</td>
                                        <td>{{ tanggal_indonesia($item->created_at) }}</td>
                                        <td>{{ $item->nama_pelanggan }}</td>
                                        <td>{{ $item->nama_pesanan }}</td>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>{{ $item->panjang }}</td>
                                        <td>{{ $item->lebar }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>{{ $item->nama_finishing }}</td>
                                        {{-- Add a checkbox for each row --}}
                                        <td class="pilih-check hide-on-start">
                                            <div class="checkbox-wrapper-46">
                                                <input class="inp-cbx" id="cbx-{{ $item->id_pesanan_detail }}"
                                                    type="checkbox" value="{{ $item->id_pesanan_detail }}">
                                                <label class="cbx" for="cbx-{{ $item->id_pesanan_detail }}"><span>
                                                        <svg width="12px" height="10px" viewbox="0 0 12 10">
                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg></span><span></span>
                                                </label>
                                            </div>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initially, hide the "Batal" and "OK" buttons, and the "Pilih" column
            $("#batalButton, #okButton, .hide-on-start").hide();

            // Check if the table is empty and hide the "Ubah" button accordingly
            var dataCount = {{ $data->count() }};
            if (dataCount === 0) {
                $("#ubahButton").hide();
            }

            // When the "Ubah" button is clicked
            $("#ubahButton").click(function() {
                // Show the "Batal" and "OK" buttons
                $("#batalButton, #okButton").show();
                // Hide the "Ubah" button
                $(this).hide();
                // Show the "Pilih" column
                $(".pilih-check").show();
            });

            // When the "Batal" button is clicked
            $("#batalButton").click(function() {
                // Hide the "Batal" and "OK" buttons
                $("#batalButton, #okButton").hide();
                // Show the "Ubah" button
                $("#ubahButton").show();
                // Hide the "Pilih" column
                $(".pilih-check").hide();
            });



            $("#okButton").click(function() {
                // Get the array of selected checkbox values (id_pesanan_detail)
                var selectedItems = $("input.inp-cbx:checked").map(function() {
                    return this.value;
                }).get();

                if (selectedItems.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Pilih minimal satu item untuk diupdate!',
                    });
                    return; // Stop further execution if no item is selected
                }

                // Show Sweet Alert confirmation
                Swal.fire({
                    icon: 'warning',
                    title: 'Konfirmasi',
                    text: "Apakah Anda yakin ingin mengubah status ke 'Sudah Ada Desain'?",
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Make an AJAX request to the Laravel controller to update the data
                        $.ajax({
                            url: "{{ route('pekerjaan.update_status_2') }}",
                            type: "POST",
                            data: {
                                ids: selectedItems,
                            },
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                // Show Sweet Alert confirmation
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                }).then(() => {
                                    // Reload the page after the SweetAlert is closed
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                // Handle errors if needed
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
