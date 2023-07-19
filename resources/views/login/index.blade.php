<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AAL Printing | Login</title>
    <link rel="stylesheet" href="{{ asset('assets/dist/css/custom/login.css') }}">
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
                <form action="" class="form-login">
                    <div class="login-field">
                        <i class="login-icon fas fa-user"></i>
                        <input type="text" name="username" id="username" class="login-input" placeholder="Username">
                    </div>
                    <div class="login-field">
                        <i class="login-icon fas fa-lock"></i>
                        <input type="password" name="password" id="password" class="login-input"
                            placeholder="Password">
                    </div>
                    <div class="button-wrapper">

                        <button type="submit" name="login">LOGIN</button>
                        <a href="">Lupa Password?</a>
                    </div>
                </form>
            </div>

            <img class="image-wrapper" src="{{ asset('assets/dist/img/login-illust.jpg') }}" alt="login">
        </div>
    </div>


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            @if (Session::has('gagal-login'))
                Toast.fire({
                    icon: 'error',
                    title: '{{ Session::get('gagal-login') }}'
                })
            @endif
        });
    </script>
</body>

</html>
