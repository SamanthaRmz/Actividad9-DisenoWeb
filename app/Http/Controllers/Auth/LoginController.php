<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginAlert;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // La autenticación fue exitosa
            return redirect()->intended('/dashboard');
        }

        // La autenticación falló
        return redirect()->back()->withErrors(['email' => 'Las credenciales proporcionadas son incorrectas.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        Mail::to($user->email)->send(new LoginAlert($user));
    }
}
