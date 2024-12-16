<?php

namespace App\Mail\Core\Auth;

use App\Models\Core\CoreAdminOption;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FirstLoginMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user = null;
    public $password = '';
    public $adminOptions = [];

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
        $this->adminOptions = CoreAdminOption::getPlucked();
    }

    public function build()
    {
        return $this->view('emails.auth.first-login');
    }
}
