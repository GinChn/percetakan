<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
</head>

<body style="font-family: Arial, sans-serif;">

    <div style="background-color: #f9f9f9; padding: 20px;">
        <h1 style="text-align: center; color: #46a9e0;">Email Lupa Password</h1>
    </div>

    <div style="background-color: #ffffff; padding: 20px;">
        <p style="font-size: 16px; line-height: 1.6;">
            Hai, {{ $nama_pengguna }}!
        </p>

        <p style="font-size: 16px; line-height: 1.6;">
            Kami menerima permintaan untuk mengatur ulang password akun Anda. Silakan klik tombol di bawah ini untuk
            melanjutkan proses reset password.
        </p>

        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('reset.password.get', $token) }}"
                style="display: inline-block; background-color: #46a9e0; color: white; padding: 12px 20px; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold;">Reset
                Password</a>
        </div>

        <p style="font-size: 16px; line-height: 1.6; margin-top: 30px;">
            Jika Anda tidak melakukan permintaan ini, abaikan saja email ini.
        </p>

        <p style="font-size: 16px; line-height: 1.6;">
            Terima kasih,<br>
            Tim Support Kami
        </p>
    </div>

    <div style="background-color: #f9f9f9; padding: 20px; text-align: center;">
        <p style="font-size: 14px; color: #999999;">
            Ini adalah email otomatis, mohon tidak membalas.
        </p>
    </div>

</body>

</html>
