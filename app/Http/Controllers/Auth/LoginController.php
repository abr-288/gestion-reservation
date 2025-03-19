<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller; // Assurez-vous que cette ligne est présente
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller // Héritage correct de Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        return redirect()->intended('/dashboard');
    }

    return redirect()->back()->withInput($request->only('email'));
}
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Déconnexion réussie.');
    }
    protected $maxAttempts = 5; // Nombre maximal de tentatives
    protected $decayMinutes = 1; // Temps d'attente en minutes
}
