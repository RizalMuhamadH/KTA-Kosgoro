@component('mail::message')
Kepada Yth, {{$user->name}}

kami menginformasikan bahwa anda sudah dapat menggunakan aplikasi kosgoro kembali

Terima kasih telah menggunakan aplikasi Kosgoro

Regards,<br>
Admin {{ config('app.name') }}
@endcomponent
