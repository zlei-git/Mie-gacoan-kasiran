@extends('layouts.app')

@section('title', 'Masuk ke Akun - Mie Gacoan')

@section('content')
<div class="bg-slate-50 min-h-[85vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-6">
        
        <!-- Brand Header with Official Logo -->
        <div class="text-center space-y-3">
            <a href="{{ route('home') }}" class="inline-block bg-white p-2.5 rounded-xl border border-slate-200">
                <img src="{{ asset('images/logo.png') }}" alt="Mie Gacoan" class="h-10 w-auto object-contain mx-auto">
            </a>
            <h2 class="text-2xl font-bold text-slate-900 font-heading">Masuk ke Sistem</h2>
            <p class="text-xs text-slate-500">Gunakan akun Anda untuk memesan, operasional kasir, atau akses manajemen.</p>
        </div>

        <!-- Demo Credentials Info Guide (Clean, No Emojis, No Bypass Buttons!) -->
        <div class="p-4 rounded-xl bg-white border border-slate-200 text-xs space-y-2 text-slate-700">
            <div class="font-bold text-slate-900 font-heading text-xs">
                Informasi Kredensial Percobaan (Demo)
            </div>
            <p class="text-[11px] text-slate-500 leading-relaxed">
                Silakan ketik atau salin email &amp; kata sandi di bawah ini ke dalam form login:
            </p>
            <div class="space-y-1 pt-1 font-mono text-[11px]">
                <div class="bg-slate-50 p-2 rounded-lg border border-slate-200 flex justify-between items-center">
                    <div><span class="font-semibold text-slate-900">Pelanggan:</span> user@demo.test</div>
                    <span class="text-slate-400">password</span>
                </div>
                <div class="bg-slate-50 p-2 rounded-lg border border-slate-200 flex justify-between items-center">
                    <div><span class="font-semibold text-slate-900">Kasir:</span> kasir@demo.test</div>
                    <span class="text-slate-400">password</span>
                </div>
                <div class="bg-slate-50 p-2 rounded-lg border border-slate-200 flex justify-between items-center">
                    <div><span class="font-semibold text-slate-900">Admin:</span> admin@demo.test</div>
                    <span class="text-slate-400">password</span>
                </div>
            </div>
        </div>

        <!-- Login Form Card -->
        <div class="bg-white p-6 sm:p-8 rounded-xl border border-slate-200 space-y-5">
            @if($errors->any())
            <div class="p-3 rounded-lg bg-red-50 border border-red-200 text-xs text-red-700">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div class="space-y-1">
                    <label for="email" class="text-xs font-bold text-slate-700">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 focus:outline-none focus:border-slate-500">
                </div>

                <div class="space-y-1">
                    <div class="flex items-center justify-between">
                        <label for="password" class="text-xs font-bold text-slate-700">Kata Sandi</label>
                    </div>
                    <input type="password" name="password" id="password" required placeholder="••••••••" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 focus:outline-none focus:border-slate-500">
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                        <input type="checkbox" name="remember" class="rounded text-slate-900 focus:ring-slate-900">
                        <span>Ingat sesi di perangkat ini</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-2.5 px-4 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition text-center">
                    Masuk ke Akun &nbsp;&rarr;
                </button>
            </form>

            <div class="pt-3 border-t border-slate-100 text-center text-xs text-slate-600">
                Belum memiliki akun pelanggan?
                <a href="{{ route('register') }}" class="font-bold text-rose-600 hover:underline ml-1">Daftar Akun Baru</a>
            </div>
        </div>
    </div>
</div>
@endsection
