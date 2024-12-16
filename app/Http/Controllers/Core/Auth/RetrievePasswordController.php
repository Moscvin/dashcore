<?php

namespace App\Http\Controllers\Core\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\AuthResetPasswordRequest;
use App\Mail\Core\Auth\ResetPasswordMail;
use App\Models\Core\CoreAdminOption;
use App\Models\Core\CoreUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class RetrievePasswordController extends Controller
{
    public function __construct()
    {
        \Config::set('captcha.secret', config('secret'));
        \Config::set('captcha.sitekey', config('sitekey'));
        $this->middleware('guest');
    }

    public function index(Request $request)
    {
        $this->data = [];
        if ($request->isMethod('post')) {
            return $this->postReset($request);
        }
        return view('core.auth.retrieve_password', $this->data);
    }

    public function sendMail(AuthResetPasswordRequest $request)
    {
        $user = CoreUser::where('email', $request->email)->first();

        if ($user) {
            if ($user->first_login == 1) {
                Session::flash('first_ko', 'Non è possibile recuperare la password perché non hai ancora effettuato il primo accesso. Per effettuare il primo accesso all’applicazione usa <a href="' . route("first-login") . '">questo link.</a>');
            } else {
                $password = Str::random(8);
                $password_hash = Hash::make($password);

                $change_pass = CoreUser::find($user->id)->update(['password' => $password_hash]);

                if ($change_pass) {
                    $adminOptions = CoreAdminOption::pluck('value', 'description')->toArray();

                    Mail::to($user->email)->send(new ResetPasswordMail($user, $adminOptions, $password));
                    Session::flash('first_ok_first', 'Username e password sono stati inviati all’indirizzo email inserito.<br>Controlla la tua email (verifica anche la cartella dello spam) e quindi usa le tue username e password per <a href="' . route("login") . '">effettuare il login.</a> ');
                } else {
                    Session::flash('first_ko', 'Si è verificato un errore, riprova.');
                }
            }
        } else {
            Session::flash('first_ko', 'L’indrizzo email inserito non è presente nei nostri sistemi; prova a riscriverlo o contatta l’assisstenza.');
        }
        return redirect(route('retrieve-password'));
    }
}
