<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show Login Form
    public function showLogin() {
        return view('auth.login');
    }

    // Handle Login Logic
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    // Show Register Form
    public function showRegister() {
        return view('auth.register');
    }

    // Handle Registration Logic (UPDATED)
    public function register(Request $request) {
        $data = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => [
                'required',
                'regex:/^[a-zA-Z]+\.[a-zA-Z]+@strathmore\.edu$/',
                'unique:users,email'
            ],
            'password' => 'required|min:6|confirmed',
        ]);

        $role = 'student';

        $user = User::create([
            'name' => $data['firstname'] . ' ' . $data['lastname'],
            'email' => strtolower($data['email']),
            'password' => Hash::make($data['password']),
            'role' => $role,
        ]);

    Auth::login($user);
    return redirect('/dashboard');
    }

    // Handle Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/login');
    }
}