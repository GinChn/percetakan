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
                    <h4 class="m-0">Pesanan Selesai</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        @if ($nama_level == 'Administrator' || $nama_level == 'Kasir')
            <div class="row mb-4">
                @if (count($data) > 0)
                    <div class="col-12">
                        <div class="col-auto float-right" id="ubahButton">
                            <button class="btn btn-sm btn-warning">Ubah</button>
                        </div>
                        <div class="col-auto float-right" id="okButton" style="display: none;">
                            <button class="btn btn-sm btn-success">OK</button>
                        </div>
                        <div class="col-auto float-right" id="batalButton" style="display: none;">
                            <button class="btn btn-sm btn-danger">Batal</button>
                        </div>
                    </div>
                @endif
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <table id="table2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nota</th>
                                    <th>Tanggal</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Aksi</th>
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
                                        <td>
                                            <a href="/pekerjaan/{{ $item->id_pesanan }}/detail"
                                                class="btn-sm btn-primary">Detail</a>
                                        </td>
                                        <td class="pilih-check hide-on-start">
                                            <div class="checkbox-wrapper-46">
                                                <input class="inp-cbx" id="cbx-{{ $item->id_pesanan }}" type="checkbox"
                                                    value="{{ $item->id_pesanan }}">
                                                <label class="cbx" for="cbx-{{ $item->id_pesanan }}"><span>
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
            $("#ubahButton").click(function() {
                // Show the "Batal" and "OK" buttons
                $("#batalButton, #okButton").show();
                // Hide the "Ubah" button
                $(this).hide();
                // Show the "Pilih" column
                $(".pilih-check").show();
            });

            $("#batalButton").click(function() {
                // Hide the "Batal" and "OK" buttons
                $("#batalButton, #okButton").hide();
                // Show the "Ubah" button
                $("#ubahButton").show();
                // Hide the "Pilih" column
                $(".pilih-check").hide();
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
                    text: "Apakah Anda yakin ingin mengubah status pesanan ke 'Sudah Diambil'?",
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Make an AJAX request to the Laravel controller to update the data
                        $.ajax({
                            url: "{{ route('pekerjaan.update_status_diambil') }}",
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
