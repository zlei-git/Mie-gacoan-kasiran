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
                <!-- Notification Bell for Admin -->
                <div class="relative">
                    <button type="button" 
                            onclick="window.OrderNotifier.toggleDrawer('adminOrderNotifDropdown')"
                            class="relative p-2.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 hover:text-stone-900 transition flex items-center gap-1.5 border border-stone-200 active:scale-95"
                            title="Notifikasi Pesanan Masuk">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span id="adminOrderNotifBadge" class="hidden px-1.5 py-0.5 rounded-full bg-rose-600 text-white text-[10px] font-black leading-none animate-pulse">0</span>
                    </button>

                    <!-- Dropdown List of Active Orders -->
                    <div id="adminOrderNotifDropdown" class="hidden absolute right-0 mt-2 bg-stone-900 border border-stone-800 rounded-2xl shadow-2xl z-50 overflow-hidden text-left" style="width: 22rem;">
                        <div class="p-3.5 border-b border-stone-800 flex items-center justify-between bg-stone-950/70">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                                <span class="font-bold text-xs text-white">Pesanan Masuk</span>
                            </div>
                            <a href="{{ route('admin.orders') }}" class="text-[10px] text-rose-400 hover:underline font-semibold">Semua Pesanan &rarr;</a>
                        </div>
                        <div id="adminOrderNotifList" class="max-h-80 overflow-y-auto divide-y divide-stone-800/60">
                            <div class="p-6 text-center text-stone-500 text-xs">
                                Memuat daftar antrean...
                            </div>
                        </div>
                    </div>
                </div>

                <span class="text-stone-400 font-medium hidden sm:inline">{{ date('d F Y') }}</span>
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

    <!-- Realtime Notifications Script -->
    <script src="{{ asset('js/order-notifications.js') }}"></script>
    @stack('scripts')
</body>
</html>
