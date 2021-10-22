@component('mail::message')
Kepada Yth, {{$user->name}}

Selamat status keanggotaan anda telah diverifikasi oleh Admin

Terima kasih telah menggunakan aplikasi Kosgoro

Regards,<br>
Admin {{ config('app.name') }}
@endcomponent
