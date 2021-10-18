<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Login</title>
</head>
<body>
    <p>
        Kepada Yth, {{$user->name}}


        <p> Bersamaan dengan ini, kami mengirimkan kode OTP untuk login kedalam Aplikasi, Adapun batas waktunya ialah selama 10 Menit dari email ini di kirimkan: </p>
        <ul>
            <li> OTP  : {{$otp}} </li>
        </ul>
    </p>


    <p>Thank you</p>
</body>
</html>
