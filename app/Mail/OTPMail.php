<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OTPMail extends Mailable
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
        return $this->view('email.otpmail')
                ->subject("OTP Login Kasgoro ".$this->tmp_user->name)
                ->from('superadmkasgoro@gmail.com','Sys Admin Kasogoro')
                ->with([
                    'user'      =>  $this->tmp_user,
                    'otp'       =>  $this->otp
                ]);
    }
}
