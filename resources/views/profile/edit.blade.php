@extends('layout')

@section('content')
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
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Profile</h3>
                </div>
                <form action="{{ route('profile.update', $profile->id_user) }}" method="POST" id="formProfile">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="email" name="username" class="form-control" value="{{ $profile->username }}" placeholder="Username">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="nama" class="form-control" value="{{ $profile->nama }}" placeholder="Nama">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <div class="input-group">
                                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ $profile->tanggal_lahir }}" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" name="alamat" class="form-control" value="{{ $profile->alamat }}" placeholder="Alamat">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>No Telp</label>
                                    <input type="text" name="no_telp" class="form-control" value="{{ $profile->no_telp }}" placeholder="Nomor Telepon">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Pendidikan</label>
                                    <input type="text" name="pendidikan" class="form-control" value="{{ $profile->pendidikan }}" placeholder="Pendidikan Terakhir">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="/profile" class="btn btn-sm btn-danger">Kembali</a>
                        <button type="submit" class="btn btn-sm btn-success float-right">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(function () {
        $('#formProfile').validate({
            rules: {
                username: {
                    required: true,
                    email: true
                },
                nama: {
                    required: true
                },
                tanggal_lahir: {
                    required: true
                },
                no_telp: {
                    required: true
                },
                alamat: {
                    required: true
                },
                pendidikan: {
                    required: true
                },
            },
            messages: {
                username: {
                    required: "Username tidak boleh kosong",
                    email: "Masukkan username menggunakan email"
                },
                nama: {
                    required: "Nama tidak boleh kosong"
                },
                tanggal_lahir: {
                    required: "Tanggal lahir tidak boleh kosong"
                },
                alamat: {
                    required: "Alamat tidak boleh kosong"
                },
                no_telp: {
                    required: "Nomor telepon tidak boleh kosong"
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endsection