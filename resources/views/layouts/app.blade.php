<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mie Gacoan - Restoran Mie Nomor 1 di Indonesia')</title>
    
    <!-- Google Fonts: Plus Jakarta Sans & Geist (Modern Vercel / Editorial aesthetic) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Geist', 'sans-serif'],
                        heading: ['Plus Jakarta Sans', 'Sora', 'sans-serif'],
                        mono: ['Plus Jakarta Sans', 'Geist', 'sans-serif'], // Eliminates generic code fonts everywhere
                    },
                    colors: {
                        brand: {
                            primary: '#e11d48',
                            dark: '#0f172a',
                            subtle: '#334155',
                            border: '#e2e8f0',
                            surface: '#f8fafc',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body, button, input, select, textarea {
            font-family: 'Plus Jakarta Sans', 'Geist', sans-serif;
            background-color: #ffffff;
            color: #0f172a;
            -webkit-tap-highlight-color: transparent;
        }
        h1, h2, h3, h4, .font-heading {
            font-family: 'Plus Jakarta Sans', 'Sora', sans-serif;
        }
        code, kbd, samp, pre, .font-mono, [class*="font-mono"] {
            font-family: 'Plus Jakarta Sans', 'Geist', sans-serif !important;
            letter-spacing: 0.025em;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Webcare-Inspired Motion Suite (https://webcareidn.com/services/) */
        html {
            scroll-behavior: smooth;
        }

        /* Scroll Reveal Base - Default to visible so content never disappears */
        .reveal-on-scroll, [data-animate] {
            opacity: 1;
            transform: translate(0, 0) scale(1);
            will-change: opacity, transform;
            transition: opacity 0.6s cubic-bezier(0.215, 0.61, 0.355, 1),
                        transform 0.6s cubic-bezier(0.215, 0.61, 0.355, 1);
        }

        /* Staggered Delay Helpers */
        [data-delay="100"] { transition-delay: 0.1s; }
        [data-delay="150"] { transition-delay: 0.15s; }
        [data-delay="200"] { transition-delay: 0.2s; }
        [data-delay="250"] { transition-delay: 0.25s; }
        [data-delay="300"] { transition-delay: 0.3s; }
        [data-delay="400"] { transition-delay: 0.4s; }
        [data-delay="500"] { transition-delay: 0.5s; }

        /* Webcare-Inspired Card Elevation & Magnetic Hover */
        .card-luxury {
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), 
                        box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1), 
                        border-color 0.25s ease;
        }
        .card-luxury:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 35px -10px rgba(15, 23, 42, 0.12), 0 8px 16px -6px rgba(15, 23, 42, 0.04);
            border-color: #cbd5e1;
        }

        /* Webcare-Inspired Button Shimmer & Active Feedback */
        .btn-luxury {
            position: relative;
            overflow: hidden;
            transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), 
                        background-color 0.2s ease, 
                        box-shadow 0.2s ease;
        }
        .btn-luxury:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -4px rgba(225, 29, 72, 0.25);
        }
        .btn-luxury:active {
            transform: scale(0.97);
        }
        .btn-shimmer::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 30%;
            height: 200%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: rotate(30deg);
            transition: none;
            opacity: 0;
            pointer-events: none;
        }
        .btn-shimmer:hover::after {
            left: 140%;
            opacity: 1;
            transition: all 0.75s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Link Underline Animation (Webcare Link Effects) */
        .link-anim {
            position: relative;
            display: inline-block;
        }
        .link-anim::after {
            content: '';
            position: absolute;
            width: 0;
            height: 1.5px;
            bottom: -2px;
            left: 0;
            background-color: currentColor;
            transition: width 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .link-anim:hover::after {
            width: 100%;
        }

        /* Floating Badge / Subtle Wave */
        @keyframes ha_float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-6px);
            }
        }
        .animate-float {
            animation: ha_float 4s ease-in-out infinite;
        }

        /* Image Zoom on Card Hover */
        .img-zoom-container {
            overflow: hidden;
        }
        .img-zoom-container img {
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .img-zoom-container:hover img,
        .card-luxury:hover .img-zoom-container img {
            transform: scale(1.08);
        }

        /* Modal Pop-up Spring */
        @keyframes popupScaleIn {
            0% {
                opacity: 0;
                transform: scale(0.93) translateY(12px);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        .modal-luxury-panel {
            animation: popupScaleIn 0.28s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased selection:bg-stone-900 selection:text-white">

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-sm border-b border-slate-200 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Mie Gacoan" class="h-11 w-auto object-contain">
                </a>

                <!-- Desktop Menu Links (Clean Editorial Style) -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-700">
                    <a href="{{ route('home') }}" class="transition-colors hover:text-rose-600 {{ request()->routeIs('home') ? 'text-rose-600 font-bold' : '' }}">Beranda</a>
                    <a href="{{ route('menu.index') }}" class="transition-colors hover:text-rose-600 {{ request()->routeIs('menu.*') ? 'text-rose-600 font-bold' : '' }}">Menu Hidangan</a>
                    <a href="{{ route('booking.index') }}" class="transition-colors hover:text-rose-600 {{ request()->routeIs('booking.*') ? 'text-rose-600 font-bold' : '' }}">Reservasi Meja</a>
                    <a href="{{ route('orders.track', ['code' => 'KM-PKP-1001']) }}" class="transition-colors hover:text-rose-600 {{ request()->routeIs('orders.track') ? 'text-rose-600 font-bold' : '' }}">Lacak Pesanan</a>
                </nav>

                <!-- Right Action Buttons -->
                <div class="flex items-center gap-3">
                    <!-- Cart Button -->
                    <button type="button" onclick="CartDrawer.open()" class="relative p-2.5 rounded-lg text-slate-700 hover:bg-slate-100 transition border border-slate-200" title="Keranjang">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span class="cart-count-badge hidden absolute -top-1.5 -right-1.5 bg-rose-600 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center ring-2 ring-white">
                            0
                        </span>
                    </button>

                    <!-- Auth Actions -->
                    @auth
                        <div class="relative">
                            <button id="userDropdownBtn" type="button" onclick="toggleUserDropdown(event)" class="btn-luxury flex items-center gap-2 px-3.5 py-2 rounded-lg border border-slate-200 hover:border-slate-300 bg-white text-xs font-semibold text-slate-800 transition">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                                <svg id="userDropdownArrow" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <!-- Dropdown Menu (Click to Toggle) -->
                            <div id="userDropdownMenu" class="hidden absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl border border-slate-200 py-1.5 z-50 transition-all modal-luxury-panel">
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="text-[10px] text-slate-400 font-medium">Peran Akun</p>
                                    <p class="text-xs font-bold text-slate-800 uppercase tracking-wider">{{ Auth::user()->role }}</p>
                                </div>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-rose-600 transition">
                                        Portal Admin
                                    </a>
                                @endif
                                @if(Auth::user()->isKasir() || Auth::user()->isAdmin())
                                    <a href="{{ route('pos.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-rose-600 transition">
                                        Terminal Kasir (POS)
                                    </a>
                                @endif
                                <a href="{{ route('orders.history') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 transition">
                                    Riwayat Transaksi
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="border-t border-slate-100 mt-1">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-xs text-rose-600 hover:bg-rose-50 font-medium transition">
                                        Keluar (Logout)
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold transition">
                            Masuk
                        </a>
                    @endauth

                    <!-- Mobile Hamburger -->
                    <button type="button" onclick="document.getElementById('mobileNavMenu').classList.toggle('hidden')" class="md:hidden p-2 rounded-lg text-slate-700 hover:bg-slate-100 border border-slate-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Nav Dropdown -->
            <div id="mobileNavMenu" class="hidden md:hidden border-t border-slate-200 py-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-sm font-semibold text-slate-700 hover:bg-slate-100">Beranda</a>
                <a href="{{ route('menu.index') }}" class="block px-3 py-2 rounded-md text-sm font-semibold text-slate-700 hover:bg-slate-100">Menu Hidangan</a>
                <a href="{{ route('booking.index') }}" class="block px-3 py-2 rounded-md text-sm font-semibold text-slate-700 hover:bg-slate-100">Reservasi Meja</a>
                <a href="{{ route('orders.track', ['code' => 'KM-PKP-1001']) }}" class="block px-3 py-2 rounded-md text-sm font-semibold text-slate-700 hover:bg-slate-100">Lacak Pesanan</a>
            </div>
        </div>
    </header>

    <!-- Main Dynamic Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Luxury Product Customizer Modal (Restrained, Editorial, No Gimmicks) -->
    <div id="productCustomizerModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="modal-backdrop fixed inset-0 bg-slate-950/60 backdrop-blur-sm transition-opacity duration-200 opacity-0" onclick="LuxuryModal.close('productCustomizerModal')"></div>

        <div class="min-h-screen px-4 text-center flex items-center justify-center p-0">
            <div class="modal-panel inline-block w-full max-w-lg my-8 text-left align-middle transition-all transform duration-200 opacity-0 scale-95 bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200">
                <!-- Modal Header with Image -->
                <div class="relative h-48 w-full bg-slate-100 overflow-hidden">
                    <img id="customizerProductImage" src="" alt="Foto Produk" class="w-full h-full object-cover">
                    <button type="button" onclick="LuxuryModal.close('productCustomizerModal')" class="absolute top-3.5 right-3.5 p-1.5 rounded-full bg-white/90 hover:bg-white text-slate-700 shadow transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <div class="absolute bottom-3.5 left-4 right-4 text-white">
                        <span id="customizerProductPrice" class="inline-block px-2.5 py-0.5 rounded text-xs font-bold bg-rose-600 text-white mb-1">Rp 0</span>
                        <h3 id="customizerProductName" class="text-xl font-bold leading-snug drop-shadow-sm">Nama Menu</h3>
                    </div>
                </div>

                <input type="hidden" id="customizerProductId">
                <input type="hidden" id="customizerProductCode">
                <input type="hidden" id="customizerProductBasePrice">

                <!-- Modal Body -->
                <div class="p-5 space-y-4 max-h-[60vh] overflow-y-auto">
                    <p id="customizerProductDesc" class="text-xs text-slate-600 leading-relaxed">Deskripsi menu.</p>

                    <!-- Spicy Level Picker -->
                    <div id="customizerSpicySection" class="space-y-2 pt-2 border-t border-slate-100">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-bold text-slate-900">Tingkat Kepedasan</label>
                            <span id="spicyIntensityText" class="text-[11px] font-semibold text-rose-600">Level 1</span>
                        </div>
                        <div id="customizerSpicyLevels" class="grid grid-cols-4 sm:grid-cols-5 gap-1.5">
                            <!-- Injected by JS -->
                        </div>
                    </div>

                    <!-- Toppings Addons -->
                    <div class="space-y-2 pt-2 border-t border-slate-100">
                        <label class="text-xs font-bold text-slate-900">Tambahan Topping</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                            <label class="flex items-center justify-between p-2.5 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="addons" value="Pangsit Krispi Isi Ayam" class="rounded text-rose-600 focus:ring-rose-500">
                                    <span class="font-medium text-slate-800">Pangsit Krispi</span>
                                </div>
                                <span class="text-slate-500 font-semibold">+Rp 4.000</span>
                            </label>
                            <label class="flex items-center justify-between p-2.5 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="addons" value="Ekstra Mozzarella Lumer" class="rounded text-rose-600 focus:ring-rose-500">
                                    <span class="font-medium text-slate-800">Keju Mozzarella</span>
                                </div>
                                <span class="text-slate-500 font-semibold">+Rp 5.000</span>
                            </label>
                        </div>
                    </div>

                    <!-- Special Notes -->
                    <div class="space-y-1 pt-1 border-t border-slate-100">
                        <label for="customizerNotes" class="text-xs font-bold text-slate-900">Catatan Pesanan</label>
                        <input type="text" id="customizerNotes" placeholder="Contoh: Pangsit dipisah, tanpa daun bawang." class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 focus:outline-none focus:border-slate-500">
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="p-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between gap-3">
                    <div class="flex items-center border border-slate-300 rounded-lg bg-white overflow-hidden">
                        <button type="button" onclick="LuxuryModal.changeQty(-1)" class="px-3 py-1.5 text-slate-600 hover:bg-slate-100 font-bold transition text-xs">-</button>
                        <input type="hidden" id="customizerQty" value="1">
                        <span id="customizerQtyDisplay" class="px-3 py-1.5 font-bold text-slate-900 text-xs">1</span>
                        <button type="button" onclick="LuxuryModal.changeQty(1)" class="px-3 py-1.5 text-slate-600 hover:bg-slate-100 font-bold transition text-xs">+</button>
                    </div>

                    <button type="button" onclick="LuxuryModal.submitCustomizer()" class="flex-1 py-2.5 px-4 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition text-center">
                        Tambahkan ke Pesanan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide-over Cart Drawer -->
    <div id="cartDrawer" class="hidden fixed inset-0 z-50 overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        <div class="drawer-backdrop fixed inset-0 bg-slate-950/50 backdrop-blur-sm transition-opacity duration-200 opacity-0" onclick="CartDrawer.close()"></div>

        <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
            <div class="drawer-panel w-screen max-w-md transform transition ease-in-out duration-200 translate-x-full bg-white shadow-xl flex flex-col">
                <div class="p-4 border-b border-slate-200 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-900">Keranjang Pesanan</h3>
                    <button type="button" onclick="CartDrawer.close()" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-4 space-y-3">
                    <div id="cartDrawerEmpty" class="text-center py-16 space-y-3">
                        <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-slate-800">Keranjang Masih Kosong</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Pilih hidangan dari menu untuk memulai pesanan.</p>
                        </div>
                        <a href="{{ route('menu.index') }}" onclick="CartDrawer.close()" class="inline-block px-3.5 py-2 rounded-lg bg-slate-900 text-white font-semibold text-xs hover:bg-slate-800 transition">
                            Lihat Menu
                        </a>
                    </div>

                    <div id="cartDrawerItems" class="space-y-2"></div>
                </div>

                <div id="cartDrawerFooter" class="p-4 border-t border-slate-200 bg-slate-50 space-y-2.5">
                    <div class="space-y-1 text-xs text-slate-600">
                        <div class="flex justify-between">
                            <span>Subtotal Menu</span>
                            <span id="cartDrawerSubtotal" class="font-semibold text-slate-800">Rp 0</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Pajak Restoran (PB1 10%)</span>
                            <span class="text-slate-500 font-medium">Termasuk</span>
                        </div>
                    </div>
                    <div class="pt-2 border-t border-slate-200 flex justify-between items-center">
                        <span class="text-xs font-bold text-slate-900">Total Pembayaran</span>
                        <span id="cartDrawerTotal" class="text-base font-extrabold text-slate-900">Rp 0</span>
                    </div>
                    <div class="flex gap-2 pt-1">
                        <button type="button" onclick="Cart.clear()" class="btn-luxury px-3 py-2 text-xs text-slate-500 hover:text-red-600 rounded-lg font-medium transition">
                            Kosongkan
                        </button>
                        <button type="button" onclick="Cart.handleProceedToCheckout(event)" class="btn-luxury flex-1 py-2.5 px-4 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs text-center transition">
                            Lanjut ke Pembayaran &nbsp;&rarr;
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Official Brand Footer (Editorial & Structured like KAI) -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-12 border-t border-slate-800 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-slate-800">
                <!-- Brand Info -->
                <div class="space-y-4">
                    <div class="bg-white p-2 rounded-xl inline-block">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Mie Gacoan" class="h-10 w-auto object-contain">
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        PT Pesta Pora Abadi (Mie Gacoan). Jaringan restoran mie pedas terkemuka di Indonesia yang menghadirkan hidangan berkualitas dengan harga terjangkau.
                    </p>
                    <div class="text-xs text-slate-400 font-medium">
                        Sertifikasi Halal ID00410000262430722
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="space-y-3">
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">Navigasi Utama</h4>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda Utama</a></li>
                        <li><a href="{{ route('menu.index') }}" class="hover:text-white transition">Menu &amp; Harga</a></li>
                        <li><a href="{{ route('booking.index') }}" class="hover:text-white transition">Reservasi Meja</a></li>
                        <li><a href="{{ route('orders.track', ['code' => 'KM-PKP-1001']) }}" class="hover:text-white transition">Status Pesanan</a></li>
                    </ul>
                </div>

                <!-- Outlets -->
                <div class="space-y-3">
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">Outlet Surabaya</h4>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><strong class="text-slate-200">Mulyosari:</strong> Jl. Raya Mulyosari No. 88</li>
                        <li><strong class="text-slate-200">Manyar:</strong> Jl. Manyar Kertoarjo No. 42</li>
                        <li><strong class="text-slate-200">Ambengan:</strong> Jl. Ambengan No. 12</li>
                        <li class="pt-1 text-slate-400 font-medium">Operasional: 10.00 - 22.00 WIB</li>
                    </ul>
                </div>

                <!-- Social Media & Contact Info -->
                <div class="space-y-3">
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">Media Sosial &amp; Kontak</h4>
                    <p class="text-xs text-slate-400">Ikuti info menu baru, promo, dan layanan bantuan pelanggan kami:</p>
                    <div class="flex flex-col gap-2.5 pt-1 text-xs text-slate-300">
                        <a href="https://instagram.com" target="_blank" rel="noopener" class="inline-flex items-center gap-2 hover:text-white transition group">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 group-hover:scale-125 transition-transform"></span>
                            <span>Instagram: @mie.gacoan</span>
                        </a>
                        <a href="https://tiktok.com" target="_blank" rel="noopener" class="inline-flex items-center gap-2 hover:text-white transition group">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 group-hover:scale-125 transition-transform"></span>
                            <span>TikTok: @miegacoan.official</span>
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="inline-flex items-center gap-2 hover:text-white transition group">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 group-hover:scale-125 transition-transform"></span>
                            <span>WhatsApp: 0812-3456-7890</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>&copy; {{ date('Y') }} PT Pesta Pora Abadi. Seluruh hak cipta dilindungi.</p>
                <div class="flex items-center gap-6 text-slate-400">
                    <span>Kebijakan Privasi</span>
                    <span>Syarat &amp; Ketentuan</span>
                    <span>Layanan Pelanggan</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Quick Order Widget (KFC Indonesia Style) -->
    <aside class="fixed bottom-6 right-6 z-40 flex flex-col items-center select-none" aria-label="Akses Pesanan Cepat">
        <!-- Floating Red Pill 'Order Now!' Button -->
        <a href="{{ route('menu.index') }}" 
           class="btn-luxury btn-shimmer px-5 py-2.5 rounded-full bg-rose-600 hover:bg-rose-700 text-white font-black text-xs tracking-wider uppercase shadow-xl shadow-rose-950/35 flex items-center gap-1.5 transition-all duration-200 hover:scale-105 active:scale-95"
           title="Pesan Sekarang">
            <span>Order Now!</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
        </a>
    </aside>

    <!-- Scripts -->
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/modal.js') }}"></script>
    <script src="{{ asset('js/offline-db.js') }}"></script>
    <script src="{{ asset('js/scroll-animate.js') }}"></script>
    <script>
        function toggleUserDropdown(event) {
            if (event) event.stopPropagation();
            const menu = document.getElementById('userDropdownMenu');
            const arrow = document.getElementById('userDropdownArrow');
            if (!menu) return;
            const isHidden = menu.classList.contains('hidden');
            if (isHidden) {
                menu.classList.remove('hidden');
                if (arrow) arrow.classList.add('rotate-180');
            } else {
                menu.classList.add('hidden');
                if (arrow) arrow.classList.remove('rotate-180');
            }
        }

        document.addEventListener('click', (e) => {
            const menu = document.getElementById('userDropdownMenu');
            const btn = document.getElementById('userDropdownBtn');
            if (menu && !menu.classList.contains('hidden')) {
                if (!btn || !btn.contains(e.target)) {
                    menu.classList.add('hidden');
                    const arrow = document.getElementById('userDropdownArrow');
                    if (arrow) arrow.classList.remove('rotate-180');
                }
            }
        });

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(() => {});
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
