<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    function index()
    {
        return view('login');
    }
    function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ],
        [
            'email.required' => 'Email is required',
            'email.email' => 'Email is not valid',
            'password.required' => 'Password is required',
        ]);

        $infoLogin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($infoLogin)) {
            // redirect ke satu‐satunya dashboard
            return redirect()->intended(route('admin.dashboard'));
        }
    
        return redirect()->back()
                         ->withErrors('Invalid email or password')
                         ->withInput();
    }
    function logout()
    {
    Auth::logout();
    return redirect('/');
}
}