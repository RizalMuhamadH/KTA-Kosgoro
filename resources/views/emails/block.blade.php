@component('mail::message')
Kepada Yth, {{$user->name}}

Mohon maaf, karena ada beberapa pertimbangan yang telah dilakukan, 
kami menginformasikan bahwa untuk sementara anda tidak dapat menggunakan aplikasi kosgoro terlebih dahulu

Terima kasih telah menggunakan aplikasi Kosgoro

Regards,<br>
Admin {{ config('app.name') }}
@endcomponent
