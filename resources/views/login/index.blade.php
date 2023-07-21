<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AAL Printing | Login</title>
    <link rel="stylesheet" href="{{ asset('assets/dist/css/custom/login.css') }}">
    {{-- sweet alert --}}
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">

</head>

<body>

    <div class="background-wrapper">
        <div class="login-container">
            <div class="login-wrapper">
                <div class="brand-logo">
                    {{-- <img src="{{ asset('assets/dist/img/logo.png') }}" alt="logo"> --}}
                    <h3>AAL Printing</h3>
                </div>
                <div class="admin-icon">
                    <img src="{{ asset('assets/dist/img/user.png') }}" alt="">
                </div>
                <h4>LOGIN KARYAWAN</h4>
                <form action="/login" class="form-login" method="post">
                    @csrf
                    <div class="login-field">
                        <i class="login-icon fas fa-user"></i>
                        <input type="text" name="username" id="username" class="login-input" placeholder="Username"
                            autofocus value="{{ old('username') }}" required>
                    </div>
                    <div class="login-field">
                        <i class="login-icon fas fa-lock"></i>
                        <input type="password" name="password" id="password" class="login-input" placeholder="Password"
                            required>
                    </div>
                    <div class="button-wrapper">

                        <button type="submit" name="login">LOGIN</button>
                        <a href="/reset-password">Lupa Password?</a>
                    </div>
                </form>
            </div>

            <img class="image-wrapper" src="{{ asset('assets/dist/img/login-illust.jpg') }}" alt="login">
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
    <script>
        @if (Session::has('gagal-login'))
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            document.addEventListener("DOMContentLoaded", function() {
                Toast.fire({
                    icon: 'error',
                    title: '{{ Session::get('gagal-login') }}',
                    timer: 3000
                });
            });
        @endif
    </script>


</body>

</html>
