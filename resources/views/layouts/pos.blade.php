<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Terminal POS Kasir - Mie Gacoan</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0c0a09;
            color: #f5f5f4;
            user-select: none;
        }
        @media print {
            body * {
                visibility: hidden;
            }
            #thermalReceiptModal, #thermalReceiptModal * {
                visibility: visible;
            }
            #thermalReceiptModal {
                position: absolute;
                left: 0;
                top: 0;
                width: 80mm;
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body class="h-full flex flex-col antialiased overflow-hidden">

    <!-- POS Header Bar -->
    <header class="h-16 bg-stone-900 border-b border-stone-800 px-4 sm:px-6 flex items-center justify-between flex-shrink-0">
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto object-contain">
            </a>
            <div class="h-5 w-[1px] bg-stone-700"></div>
            <div class="flex items-center gap-2 text-xs">
                <span class="px-2 py-0.5 rounded bg-rose-600 text-white font-extrabold uppercase tracking-wider">POS Kasir</span>
                <span class="text-stone-300 font-semibold">{{ $activeBranch->name ?? 'Outlet Mulyosari' }}</span>
            </div>
        </div>

        <!-- Center: Live Clock & Network Status -->
        <div class="flex items-center gap-4 text-xs">
            <div id="liveClock" class="font-mono text-stone-400 hidden sm:block">10:00:00 WIB</div>
            <!-- Online / Offline Network Pill -->
            <div id="networkStatusPill" class="flex items-center px-2.5 py-1 rounded-full bg-stone-800 border border-stone-700 text-stone-300 font-medium text-[11px]">
                <span id="networkStatusLabel">Online Terhubung</span>
            </div>
            <!-- Offline Queue Sync Button -->
            <button type="button" onclick="OfflineDB.syncWithServer()" id="offlineSyncBadge" class="hidden flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500 hover:bg-amber-600 text-stone-950 font-bold text-xs transition">
                <span>0 Menunggu Sync</span>
            </button>
        </div>

        <!-- Right: Staff & Navigation -->
        <div class="flex items-center gap-3">
            <div class="text-right text-xs hidden sm:block">
                <div class="font-bold text-white">{{ Auth::user()->name ?? 'Kasir Mulyosari' }}</div>
                <div class="text-stone-400 text-[10px]">Shift Aktif</div>
            </div>
            @if(Auth::user() && Auth::user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-200 text-xs font-semibold border border-stone-700 transition">
                Portal Admin
            </a>
            @endif
            <a href="{{ route('home') }}" class="p-2 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-300 transition" title="Ke Beranda">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            </a>
        </div>
    </header>

    <!-- Main Content Grid -->
    <div class="flex-1 flex overflow-hidden">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/offline-db.js') }}"></script>
    <script>
        // Live Clock
        function updateClock() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', { hour12: false }) + ' WIB';
            const clockEl = document.getElementById('liveClock');
            if (clockEl) clockEl.textContent = timeStr;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Network Status Listener
        function updateNetworkStatus() {
            const isOnline = navigator.onLine;
            const pill = document.getElementById('networkStatusPill');
            const label = document.getElementById('networkStatusLabel');
            if (isOnline) {
                pill.className = 'flex items-center px-2.5 py-1 rounded-full bg-stone-800 border border-stone-700 text-stone-300 font-medium text-[11px]';
                label.textContent = 'Online Terhubung';
            } else {
                pill.className = 'flex items-center px-2.5 py-1 rounded-full bg-amber-900/40 border border-amber-700/60 text-amber-300 font-medium text-[11px]';
                label.textContent = 'Mode POS Offline';
            }
        }
        window.addEventListener('online', updateNetworkStatus);
        window.addEventListener('offline', updateNetworkStatus);
        updateNetworkStatus();
    </script>
    @stack('scripts')
</body>
</html>
