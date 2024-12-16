<?php

namespace App\Http\Controllers\Core\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\AuthResetPasswordRequest;
use App\Mail\Core\Auth\FirstLoginMail;
use App\Models\Core\CoreAdminOption;
use App\Models\Core\CoreUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class FirstLoginController extends Controller
{
    public function __construct()
    {
        \Config::set('captcha.secret', CoreAdminOption::getOption('secret'));
        \Config::set('captcha.sitekey', CoreAdminOption::getOption('sitekey'));
    }

    public function index()
    {
        return view('core.auth.first_login');
    }

    public function sendMail(AuthResetPasswordRequest $request)
    {
        $user = CoreUser::where('email', $request->email)->first();

        if ($user) {
            if ($user->first_login) {
                $password = Str::random(8);
                $password_hash = bcrypt($password);

                Mail::to($user->email)->send(new FirstLoginMail($user, $password));
                $user->update([
                    'password' => $password_hash,
                    'first_login' => 0,
                ]);

                Session::flash('first_ok_first', 'Username e password sono stati inviati all’indirizzo email inserito. Controlla la tua email (verifica anche la cartella dello spam) e quindi usa le tue username e password per <a href="' . route("login") . '">effettuare il login.</a>');
            } else {
                Session::flash('first_ok', 'Hai già effettuato il primo login! Se desideri reimpostare la password clicca su questo <a href="' . route("/retrieve-password") . '">link</a>.');
            }
        } else {
            Session::flash('first_ko', 'L’indrizzo email inserito non è presente nei nostri sistemi; prova a riscriverlo o contatta l’assisstenza.');
        }
        return redirect(route('first-login'));
    }
}
