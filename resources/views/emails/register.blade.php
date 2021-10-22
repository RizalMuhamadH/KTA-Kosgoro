@component('mail::message')
Kepada Yth, {{$user->name}}

Selamat bergabung menjadi anggota Kosgoro, dengan No Member {{$user->no_member}}

Terima kasih telah menggunakan aplikasi Kosgoro

Regards,<br>
Admin {{ config('app.name') }}
@endcomponent
