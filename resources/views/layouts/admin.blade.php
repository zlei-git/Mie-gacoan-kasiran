<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel Restoran') - Mie Gacoan</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full flex bg-stone-100 text-stone-900 font-sans antialiased overflow-hidden">

    <!-- Sidebar Navigation -->
    <aside class="w-64 bg-stone-900 text-stone-300 flex flex-col border-r border-stone-800 flex-shrink-0">
        <!-- Brand Header with Logo -->
        <div class="h-20 flex items-center px-6 border-b border-stone-800">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Mie Gacoan" class="h-10 w-auto object-contain">
                <div>
                    <div class="text-xs font-bold text-white uppercase tracking-wider">Resto Admin</div>
                    <div class="text-[10px] text-stone-400">Backoffice V1.0</div>
                </div>
            </a>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto text-xs font-semibold">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                Dashboard Ringkasan
            </a>
            <a href="{{ route('admin.orders') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('admin.orders*') ? 'bg-slate-800 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                Pesanan &amp; Dapur
            </a>
            <a href="{{ route('admin.products') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('admin.products*') ? 'bg-slate-800 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                Manajemen Menu
            </a>
            <a href="{{ route('admin.tables') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('admin.tables*') ? 'bg-slate-800 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                Denah Meja Restoran
            </a>
            <a href="{{ route('admin.bookings') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('admin.bookings*') ? 'bg-slate-800 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                Reservasi Tamu
            </a>
            <a href="{{ route('admin.promos') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('admin.promos*') ? 'bg-slate-800 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                Voucher &amp; Promo
            </a>

            <div class="pt-4 border-t border-slate-800 mt-4">
                <span class="px-3.5 text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-2">Akses Cepat</span>
                <a href="{{ route('pos.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-lg text-slate-300 hover:bg-slate-800 transition">
                    Buka Terminal POS &rarr;
                </a>
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition">
                    Website Pelanggan &rarr;
                </a>
            </div>
        </nav>

        <!-- Current User Profile & Logout -->
        <div class="p-4 border-t border-stone-800 bg-stone-950/40">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-white">{{ Auth::user()->name ?? 'Administrator' }}</div>
                    <div class="text-[10px] text-stone-500">{{ Auth::user()->email ?? 'admin@demo.test' }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-2 text-stone-400 hover:text-red-400 hover:bg-stone-800 rounded-lg transition" title="Keluar">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Workspace Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Nav -->
        <header class="h-20 bg-white border-b border-stone-200 px-8 flex items-center justify-between flex-shrink-0">
            <div>
                <h2 class="text-lg font-extrabold text-stone-900">@yield('title')</h2>
                <p class="text-xs text-stone-500">Sistem Operasional & Kontrol Restoran</p>
            </div>
            <div class="flex items-center gap-4 text-xs">
                <span class="text-stone-400 font-medium">{{ date('d F Y') }}</span>
            </div>
        </header>

        <!-- Scrollable Page Content -->
        <main class="flex-1 overflow-y-auto p-8">
            @if(session('toast_success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
                <span>✓</span> {{ session('toast_success') }}
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
