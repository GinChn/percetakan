@extends('layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profile</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-success card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="/assets/dist/img/user.png"
                                alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center mb-3 mt-3">{{ $profile->nama }}</h3>
                        <a href="/profile/{{ $profile->id_user }}/edit"
                            class="btn btn-sm btn-success bg-gradient btn-block"><b>Edit Profile</b></a>
                        <a href="/profile/ganti-password" class="btn btn-sm btn-warning bg-gradient btn-block"><b>Ganti
                                Password</b></a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Data Profile</h3>
                    </div>
                    <div class="card-body">
                        <strong>Nama</strong>
                        <p class="text-muted">{{ $profile->nama }}</p>
                        <hr>
                        <strong>Tanggal Lahir</strong>
                        <p class="text-muted">{{ tanggal_indonesia($profile->tanggal_lahir, false) }}</p>
                        <hr>
                        <strong>Alamat</strong>
                        <p class="text-muted">{{ $profile->alamat }}</p>
                        <hr>
                        <strong>No Telepon</strong>
                        <p class="text-muted">{{ $profile->no_telp }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Use SweetAlert2 version 11 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    @if ($message = Session::get('success'))
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            document.addEventListener("DOMContentLoaded", function() {
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('success') }}',
                    timer: 3000
                });
            });
        </script>
    @endif
@endsection
