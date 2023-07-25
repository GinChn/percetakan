@extends('layout')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Profile</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title">Ganti Password</h3>
                    </div>
                    <form action="{{ route('ganti.password') }}" method="POST" id="gantiPassword">
                        @csrf

                        <div class="card-body">
                            <div class="form-group">
                                <label for="password_lama">Password Lama</label>
                                <input type="password" name="password_lama" id="password_lama" class="form-control"
                                    required>
                                @error('password_lama')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_baru">Password Baru</label>
                                <input type="password" name="password_baru" id="password_baru" class="form-control"
                                    required>
                                @error('password_baru')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="konfirmasi_password">Konfirmasi Password Baru</label>
                                <input type="password" name="konfirmasi_password" id="konfirmasi_password"
                                    class="form-control" required>
                                @error('konfirmasi_password')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="/profile" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Use SweetAlert2 version 11 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>

    @if ($message = Session::get('error'))
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            document.addEventListener("DOMContentLoaded", function() {
                Toast.fire({
                    icon: 'error',
                    title: '{{ $message }}',
                    timer: 3000
                });
            });
        </script>
    @endif
@endsection
