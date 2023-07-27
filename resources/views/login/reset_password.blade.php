<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
    <link rel="icon" sizes="16x16" href="{{ asset('assets/dist/img/logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dist/css/custom/reset-password.css') }}">
</head>

<body>

    <div class="background-wrapper">
        <h1>AAL Printing</h1>
        <div class="reset-container">

            <div class="reset-wrapper">
                <div class="title">
                    <h3>Reset Password</h3>
                </div>
                <p>Masukkan alamat email yang terdaftar untuk menerima tautan reset kata sandi.</p>

                <div class="form-reset">
                    <form action="{{ route('password.email') }}" method="post">
                        @csrf
                        <label for="email">Email</label>
                        <input type="email" name="username" id="email">
                        <button type="submit" name="reset">Kirim</button>
                    </form>
                </div>
                <a href="/login">Kembali ke halaman Login</a>
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

    @if ($errors->any())
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            document.addEventListener("DOMContentLoaded", function() {
                @foreach ($errors->all() as $error)
                    Toast.fire({
                        icon: 'error',
                        title: '{{ $error }}',
                        timer: 3000
                    });
                @endforeach
            });
        </script>
    @endif
    @if (session('status'))
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
                    title: '{{ session('status') }}',
                    timer: 3000
                });
            });
        </script>
    @endif

</body>

</html>
