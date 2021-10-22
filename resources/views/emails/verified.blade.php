@component('mail::message')
Kepada Yth, {{$user->name}}

Selamat status keanggotaan anda telah diverifikasi oleh Admin, nomor member anda adalah {{$user->no_member}}

Terima kasih telah menggunakan aplikasi Kosgoro

Regards,<br>
Admin {{ config('app.name') }}
@endcomponent
