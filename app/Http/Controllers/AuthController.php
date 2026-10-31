<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $login = $data['login'];

        $user = User::query()
            ->where(function ($query) use ($login) {
                $query->where('username', $login)
                    ->orWhere('email', $login)
                    ->orWhere('nim', $login);
            })
            ->where('role', $data['role'])
            ->first();

        if (
            ! $user ||
            ! Auth::attempt([
                'username' => $user->username,
                'password' => $data['password'],
            ])
        ) {
            return back()
                ->withErrors([
                    'login' => 'Username, email, NIM, password, atau role salah.',
                ])
                ->onlyInput('login', 'role');
        }

        $request->session()->regenerate();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isPimpinan()) {
            return redirect()->route('pimpinan.dashboard');
        }

        return redirect()->route('mahasiswa.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
