<?php

namespace App\Mail\Core\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user;
    public $adminOptions;
    public $password;

    public function __construct($user, $adminOptions, $password)
    {
        $this->user = $user;
        $this->adminOptions = $adminOptions;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('La tua nuova password per accedere a ' .$this->adminOptions['web_application_name'])
            ->view('emails.auth.retrieve-password');
    }
}
