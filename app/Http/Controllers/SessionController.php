<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        // dd(request()->all()); || To control the input
        
        // validate - peform validation for include email and password
        $validatedAttributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        
        // attempt to login the user - Space to make rules for login/validation
        if (! Auth::attempt($validatedAttributes)) {
            throw ValidationException::withMessages([
                'email' => 'Sorry, those credentials do not match.'
            ]);
        }

        // regenrate the session token - Safe the Sessiontoken against "HiJacking" - Hacking
        request()->session()->regenerate();

        // redirect
        return redirect('/jobs');
    }

    public function destroy()
    {
        // dd('log the user out');
        Auth::logout();

        return redirect('/');
    }
}
