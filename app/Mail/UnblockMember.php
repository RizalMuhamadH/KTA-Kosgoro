<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class UnblockMember extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user;
    public function __construct($tmp_user)
    {
        $this->user = $tmp_user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.unblock')
        ->subject("Email Unblock Notification ".$this->user->name." ".Carbon::now()->timezone('Asia/Jakarta'))
        ->from('superadmkasgoro@gmail.com','Sys Admin Kasogoro')
        ->with([
            'user'      =>  $this->user,
        ]);
    }
}
