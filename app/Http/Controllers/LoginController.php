<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {

    public function index() {
        return view('login.index');
    }

    public function store(Request $request) : RedirectResponse {
        $credentials = $request->validate([
            'login' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['login' => $credentials['login'], 'password' => $credentials['password'], 'active' => 1])) {
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        return back()->withErrors([
            'login' => 'Неверный логин или пароль!',
        ])->onlyInput('login');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
