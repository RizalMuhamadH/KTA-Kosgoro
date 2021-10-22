@component('mail::message')
Kepada Yth, {{$user->name}}

Silakan masukkan OTP ini untuk melanjutkan aktivitas anda di aplikasi Kosgoro ini:

OTP  : {{$otp}}

Jaga keamanan akun Anda dengan tidak membagikan OTP kepada siapa pun, termasuk admin.


Terima kasih telah menggunakan aplikasi Kosgoro

Regards,<br>
Admin {{ config('app.name') }}
@endcomponent
