<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            try {
                $test = password_hash('password', PASSWORD_BCRYPT, ['cost' => 12]);
            } catch (\Throwable $err) {
                return response()->json([
                    'real_error' => $err->getMessage(),
                    'class' => get_class($err),
                    'supported_algos' => function_exists('password_algos') ? password_algos() : [],
                ], 500);
            }

            $input = trim($request->input('email', ''));
            $password = $request->input('password', '');

            // Map short username to email if entered
            if ($input === 'admin') {
                $input = 'admin@miegacoan.co.id';
            } elseif ($input === 'kasir') {
                $input = 'kasir@miegacoan.co.id';
            }

            $remember = $request->boolean('remember');

            // Try authenticating with entered email, or fallback to demo.test / miegacoan.co.id
            $attempts = [
                $input,
                str_replace('@demo.test', '@miegacoan.co.id', $input),
                str_replace('@miegacoan.co.id', '@demo.test', $input),
            ];

            foreach (array_unique($attempts) as $emailCandidate) {
                if (Auth::attempt(['email' => $emailCandidate, 'password' => $password], $remember)) {
                    $request->session()->regenerate();
                    $user = Auth::user();

                    return $this->redirectBasedOnRole($user)
                        ->with('toast_success', 'Selamat datang kembali, ' . $user->name . '!');
                }
            }

            return back()->withErrors([
                'email' => 'Email atau kata sandi yang Anda masukkan tidak sesuai.',
            ])->onlyInput('email');
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    public function showRegisterForm()
    {
        if (Auth::check() && Auth::user()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('toast_success', 'Registrasi berhasil! Selamat menikmati menu pedas favorit Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('toast_info', 'Anda telah berhasil keluar.');
    }

    private function redirectBasedOnRole(?User $user)
    {
        if (!$user) {
            Auth::logout();
            return redirect()->route('login');
        }
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->isKasir()) {
            return redirect()->route('pos.index');
        }
        return redirect()->route('home');
    }
}
