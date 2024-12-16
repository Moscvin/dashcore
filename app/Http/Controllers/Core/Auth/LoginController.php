<?php

namespace App\Http\Controllers\Core\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('core.auth.login');
    }

    public function auth(Request $request)
    {
        if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $type = 'email';
        } else {
            $type = 'username';
        }

        $credentials = $request->validate([
            $type => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/home');
        }

        return back()->withErrors(['email' => 'Hai inserito una username o password errate. Riprova.'])->onlyInput('email');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
