<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordResetCode;
use App\Mail\ResetPasswordCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('pages.auth.login');
    }

    public function showForgotPassword()
    {
        return view('pages.auth.forgot-password');
    }

    public function sendResetCode(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $validated['email'])->first();
        if (!$user) {
            return back()->withErrors([
                'email' => 'We could not find a user with that email address.',
            ])->onlyInput('email');
        }

        $code = (string) random_int(100000, 999999);

        PasswordResetCode::where('email', $validated['email'])
            ->whereNull('used_at')
            ->update(['used_at' => now()]);

        PasswordResetCode::create([
            'email' => $validated['email'],
            'code_hash' => Hash::make($code),
            'expires_at' => now()->addMinutes(15),
        ]);

        Mail::to($validated['email'])->send(new ResetPasswordCodeMail($code));

        return redirect()->route('password.reset_form', ['email' => $validated['email']])
            ->with('success', 'We have emailed you a reset code.');
    }

    public function showResetPassword(Request $request)
    {
        $email = $request->query('email');
        return view('pages.auth.reset-password', compact('email'));
    }

    public function resetPasswordWithCode(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|max:6',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $record = PasswordResetCode::where('email', $validated['email'])
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->latest('id')
            ->first();

        if (!$record || !Hash::check($validated['code'], $record->code_hash)) {
            return back()->withErrors([
                'code' => 'Invalid or expired reset code.',
            ])->withInput([
                'email' => $validated['email'],
            ]);
        }

        $user = User::where('email', $validated['email'])->first();
        if (!$user) {
            return back()->withErrors([
                'email' => 'We could not find a user with that email address.',
            ])->withInput([
                'email' => $validated['email'],
            ]);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        $record->update([
            'used_at' => now(),
        ]);

        return redirect()->route('login')->with('success', 'Password reset successfully. You can now login.');
    }

    public function showAdminLogin()
    {
        return view('pages.admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            if (auth()->user() && auth()->user()->is_admin) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('admin.login')->withErrors([
                    'email' => 'Please use the admin login page.',
                ])->onlyInput('email');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            if (!auth()->user() || !auth()->user()->is_admin) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'You are not authorized to access the admin area.',
                ])->onlyInput('email');
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => false,
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}

