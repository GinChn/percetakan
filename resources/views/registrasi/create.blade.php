@extends('layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Registrasi User</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form tambah user</h3>
                </div>
                <form action="{{ route('registrasi.store') }}" method="POST" id="formRegistrasi">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="email" name="username" class="form-control" placeholder="Username">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <div class="input-group">
                                        <input type="date" name="tanggal_lahir" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" name="alamat" class="form-control" placeholder="Alamat">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>No Telp</label>
                                    <input type="text" name="no_telp" class="form-control" placeholder="Nomor Telepon">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Pendidikan</label>
                                    <input type="text" name="pendidikan" class="form-control" placeholder="Pendidikan Terakhir">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Level</label>
                                    <select class="custom-select" name="level">
                                        <option value="">Pilih Level</option>
                                        @foreach ($level as $item)
                                        <option value="{{ $item->id_level }}">{{ $item->nama_level }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
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
        $('#formRegistrasi').validate({
            rules: {
                username: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 5
                },
                nama: {
                    required: true
                },
                tanggal_lahir: {
                    required: true
                },
                alamat: {
                    required: true
                },
                no_telp: {
                    required: true
                },
                pendidikan: {
                    required: true
                },
                level: {
                    required: true
                },
            },
            messages: {
                username: {
                    required: "Username tidak boleh kosong",
                    email: "Masukkan userame dengan format email yang benars"
                },
                password: {
                    required: "Password tidak boleh kosong",
                    minlength: "Panjang password minimal 5 karakter"
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