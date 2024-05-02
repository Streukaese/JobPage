<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create() 
    {
        return view('auth.register');
        // dd('hello');
    }

    public function store()
    {
        // return view('auth')
        // dd(request()->all());

        // validate the form
        $validatedAttributes = request()->validate([
            'first_name'            => ['required', 'min:3', 'max:30'],
            'last_name'             => ['required', 'min:3', 'max:30'],
            'email'                 => ['required', 'string', 'email', 'max:40'],
        // \Illuminate\Validation\Rule::unique('users')],   // email_confirmation
            'password'              => ['required', Password::min(5)->max(20)->numbers()->letters(), 'confirmed'] // password_confirmation
        ]);                                         // Password::min(6)
        
        // dd($validatedAttributes);

        // create the user in DB
        $user = User::create($validatedAttributes);

        // log in
        Auth::login($user);

        // redirect somewhere
        return redirect('/jobs');
    }
}
