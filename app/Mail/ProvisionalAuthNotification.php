<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProvisionalAuthNotification extends Mailable
{
    use Queueable, SerializesModels;


    protected $token;


    /**
     * ProvisionalAuthNotification constructor.
     *
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.verification')
            ->with(['token' => $this->token]);
    }
}
