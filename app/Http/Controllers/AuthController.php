<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function showRegister() { return view('auth.register'); }
    public function showLogin() { return view('auth.login'); }

    public function register(Request $request)
    {
        $rules = [
            'first_name'   => 'required|string|max:50',
            'last_name'    => 'required|string|max:50',
            'email'        => 'required|email|unique:users',
            'password'     => 'required|min:8|confirmed',
            'role'         => 'required|in:doctor,patient',
            'avatar'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        if ($request->role === 'doctor') {
            $rules['specialization']    = 'required|string|max:100';
            $rules['consultation_fee']  = 'required|numeric|min:0';
            $rules['biography']         = 'required|string|max:1000';
        }

        $validated = $request->validate($rules);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create([
            'first_name'        => $validated['first_name'],
            'last_name'         => $validated['last_name'],
            'email'             => $validated['email'],
            'password'          => Hash::make($validated['password']),
            'role'              => $validated['role'],
            'avatar'            => $avatarPath,
            'specialization'    => $request->specialization ?? null,
            'consultation_fee'  => $request->consultation_fee ?? null,
            'biography'         => $request->biography ?? null,
        ]);

        Auth::login($user);
        return redirect()->route($user->role . '.dashboard');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route(Auth::user()->role . '.dashboard');
        }

        return back()->withErrors(['email' => 'Identifiants incorrects.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}