<?php

namespace App\Http\Controllers;

use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (!request()->boolean('switch') && in_array(session('role'), ['admin', 'verifikator'], true) && session()->has('username')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = UserAccount::where('username', $credentials['username'])->first();

        if (!$user) {
            return back()->withErrors(['login' => 'Username tidak ditemukan.'])->withInput();
        }

        if (!$this->passwordMatches($credentials['password'], $user)) {
            return back()->withErrors(['login' => 'Password salah.'])->withInput();
        }

        if (!in_array($user->role, ['admin', 'verifikator'], true)) {
            return back()->withErrors(['login' => 'Akun ini tidak memiliki akses login.'])->withInput();
        }

        $request->session()->regenerate();

        session([
            'username' => $user->username,
            'role' => $user->role,
        ]);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function passwordMatches($password, UserAccount $user)
    {
        $storedPassword = (string) $user->password;
        $isValidHash = false;

        try {
            $isValidHash = Hash::check($password, $storedPassword);
        } catch (\RuntimeException $exception) {
            $isValidHash = false;
        }

        if ($isValidHash) {
            if (Hash::needsRehash($storedPassword)) {
                $user->update(['password' => Hash::make($password)]);
            }

            return true;
        }

        if (hash_equals($storedPassword, $password)) {
            $user->update(['password' => Hash::make($password)]);

            return true;
        }

        return false;
    }

}
