<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOTPMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $tmp_user, $otp;
    public function __construct($tmp_user, $otp)
    {
        $this->tmp_user =   $tmp_user;
        $this->otp      =   $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.otp')
            ->subject("OTP Login Kasgoro ".$this->tmp_user->name." ".Carbon::now()->timezone('Asia/Jakarta'))
            ->from('superadmkasgoro@gmail.com','Sys Admin Kasogoro')
            ->with([
                'user'      =>  $this->tmp_user,
                'otp'       =>  $this->otp
            ]);;
    }
}
