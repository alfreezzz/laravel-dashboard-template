<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if (! $user->is_active) {
                Auth::logout();

                return back()->withErrors(['email' => 'Akun Anda dinonaktifkan'])->onlyInput('email');
            }

            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('user.dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau password salah'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showRegister()
    {
        if (! config('auth.registration_enabled')) {
            abort(404);
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        if (! config('auth.registration_enabled')) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // explicitly set role to user; migration default also applies but be explicit
        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('user.dashboard');
    }

    public function settings()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return view('auth.settings', compact('user'));
    }

    public function updateSettings(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $data = $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (! Hash::check($data['old_password'], $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama tidak cocok']);
        }

        $user->password = Hash::make($data['new_password']);
        $user->save();

        return back()->with('success', 'Password berhasil diubah');
    }

    // ---------------------------------------------------------------------
    // password reset helpers
    // ---------------------------------------------------------------------

    public function showForgotPassword()
    {
        if (! config('auth.password_reset_enabled')) {
            abort(404);
        }

        return view('auth.forgot-password');
    }

    public function sendForgotPasswordLink(Request $request)
    {
        if (! config('auth.password_reset_enabled')) {
            abort(404);
        }

        $request->validate(['email' => 'required|email']);

        $status = \Illuminate\Support\Facades\Password::sendResetLink(
            $request->only('email')
        );

        return $status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT
                    ? back()->with('success', __($status))
                    : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPassword(string $token)
    {
        if (! config('auth.password_reset_enabled')) {
            abort(404);
        }

        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        if (! config('auth.password_reset_enabled')) {
            abort(404);
        }
        
        $data = $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = \Illuminate\Support\Facades\Password::reset(
            $data,
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                \Illuminate\Support\Facades\Auth::login($user);
            }
        );

        if ($status === \Illuminate\Support\Facades\Password::PASSWORD_RESET) {
            $user = Auth::user();
            return redirect($user->role === 'admin' ? route('admin.dashboard') : route('user.dashboard'))
                ->with('success', __($status));
        }
        return back()->withErrors(['email' => [__($status)]]);
    }
}
