<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{ asset('assets/dist/css/custom/reset-password.css') }}">
    <style>
        .reset-container {
            width: 30%;
        }

        .reset-wrapper p {
            text-align: center
        }

        .text-danger {
            color: #dc3545;
        }

        .text-danger:hover {
            color: #bd2130;
        }

        /* Additional style for error messages */
        .error-message {
            font-size: 14px;
            color: #dc3545;
            margin-top: 5px;
        }

        .flash-error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            padding: 8px 15px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        form input {
            margin-bottom: 10px;
        }
    </style>

</head>

<body>

    <div class="background-wrapper">
        <h1>AAL Printing</h1>
        <div class="reset-container">

            <div class="reset-wrapper">
                <div class="title">
                    <h3>Ganti Password</h3>
                </div>
                <p>Masukkan Password Baru</p>

                <div class="form-reset">
                    <form action="{{ route('reset.password.post') }}" method="post">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required>
                        @error('password')
                            <span class="text-danger error-message flash-error">{{ $message }}</span>
                        @enderror
                        <label for="confirmPassword">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="confirmPassword" required>
                        @error('password_confirmation')
                            <span class="text-danger error-message flash-error">{{ $message }}</span>
                        @enderror

                        <button type="submit">Ubah Password</button>
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
    @if (session('error'))
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
                    title: '{{ session('error') }}',
                    timer: 3000
                });
            });
        </script>
    @endif

</body>

</html>
