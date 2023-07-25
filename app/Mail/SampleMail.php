<?php
// app/Mail/SampleMail.php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SampleMail extends Mailable
{
    use SerializesModels;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.sample')
            ->subject('Your Email Subject'); // Assuming you have an email template in 'resources/views/emails/sample.blade.php'
    }
}
