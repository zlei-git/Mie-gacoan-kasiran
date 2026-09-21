@extends('layouts.app')

@section('title', 'Daftar Akun Pelanggan - Mie Gacoan')

@section('content')
<div class="bg-slate-50 min-h-[85vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-6">
        
        <div class="text-center space-y-3">
            <a href="{{ route('home') }}" class="inline-block bg-white p-2.5 rounded-xl border border-slate-200">
                <img src="{{ asset('images/logo.png') }}" alt="Mie Gacoan" class="h-10 w-auto object-contain mx-auto">
            </a>
            <h2 class="text-2xl font-bold text-slate-900 font-heading">Daftar Akun Baru</h2>
            <p class="text-xs text-slate-500">Buat akun pelanggan untuk pemesanan cepat dan riwayat pesanan.</p>
        </div>

        <div class="bg-white p-6 sm:p-8 rounded-xl border border-slate-200 space-y-4">
            @if($errors->any())
            <div class="p-3 rounded-lg bg-red-50 border border-red-200 text-xs text-red-700">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-3.5">
                @csrf

                <div class="space-y-1">
                    <label for="name" class="text-xs font-bold text-slate-700">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus placeholder="Rian Anggara" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 focus:outline-none focus:border-slate-500">
                </div>

                <div class="space-y-1">
                    <label for="email" class="text-xs font-bold text-slate-700">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="rian@contoh.com" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 focus:outline-none focus:border-slate-500">
                </div>

                <div class="space-y-1">
                    <label for="phone" class="text-xs font-bold text-slate-700">Nomor Telepon / WhatsApp</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required placeholder="081234567890" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 focus:outline-none focus:border-slate-500">
                </div>

                <div class="space-y-1">
                    <label for="password" class="text-xs font-bold text-slate-700">Kata Sandi</label>
                    <input type="password" name="password" id="password" required placeholder="Minimal 8 karakter" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 focus:outline-none focus:border-slate-500">
                </div>

                <div class="space-y-1">
                    <label for="password_confirmation" class="text-xs font-bold text-slate-700">Ulangi Kata Sandi</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Konfirmasi kata sandi" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 focus:outline-none focus:border-slate-500">
                </div>

                <button type="submit" class="w-full py-2.5 px-4 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition text-center mt-2">
                    Daftar Akun Sekarang &nbsp;&rarr;
                </button>
            </form>

            <div class="pt-3 border-t border-slate-100 text-center text-xs text-slate-600">
                Sudah memiliki akun?
                <a href="{{ route('login') }}" class="font-bold text-slate-900 hover:underline ml-1">Masuk</a>
            </div>
        </div>
    </div>
</div>
@endsection
