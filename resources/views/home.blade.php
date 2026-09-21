@extends('layouts.app')

@section('title', 'Mie Gacoan - Restoran Mie Nomor 1 di Indonesia')

@section('content')
<!-- Hero Section (Jagonya Mie Pedas Lockup with Bright Natural Photo - No Dark Blue Tint) -->
<section class="relative min-h-[92vh] sm:min-h-screen flex items-center bg-black text-white overflow-hidden py-24 sm:py-32 lg:py-40">
    <!-- Natural Bright Background Dish Image (Bright, Natural Warmth, No Blue Filter) -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/hero-dish.png') }}" 
             alt="Hidangan Spesial Mie Gacoan, Dimsum, dan Minuman Segar" 
             class="w-full h-full object-cover object-center brightness-115 contrast-[1.02] saturate-110">
        <!-- Soft Neutral Warm Dark Gradient on Left Only (Zero Blue Tint, High Contrast for Frame) -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/55 via-black/15 to-transparent pointer-events-none"></div>
    </div>

    <!-- Banner Content Container (Left-Aligned Graphic Lockup Frame) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="max-w-2xl">
            
            <!-- Graphic Tagline Lockup Frame -->
            <div class="inline-block relative border-2 border-white rounded-2xl sm:rounded-3xl p-6 sm:p-9 md:p-10 backdrop-blur-md bg-black/40 shadow-2xl">
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white uppercase font-heading tracking-tight leading-[1.05] drop-shadow-md">
                    JAGONYA<br>MIE PEDAS
                </h1>
                <div class="mt-3 sm:mt-4 flex items-center gap-3">
                    <span class="h-0.5 w-6 sm:w-10 bg-rose-500"></span>
                    <span class="text-xs sm:text-sm md:text-base font-bold text-white tracking-widest uppercase font-heading drop-shadow-sm">
                        Jaminan Cita Rasa Juara
                    </span>
                    <span class="h-0.5 w-6 sm:w-10 bg-rose-500"></span>
                </div>
            </div>

            <!-- Official Brand Credentials & Social Handles -->
            <div class="mt-6 sm:mt-8 space-y-2">
                <div class="inline-flex flex-wrap items-center gap-2.5 sm:gap-3 text-xs sm:text-sm text-white px-4 py-2 rounded-full bg-black/50 backdrop-blur-md border border-white/20 shadow-md">
                    <span class="inline-flex items-center gap-1.5 font-bold text-emerald-400">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Halal ID00410000262430722
                    </span>
                    <span class="text-white/40">|</span>
                    <span class="text-white font-semibold">@mie.gacoan</span>
                    <span class="text-white/40">|</span>
                    <span class="text-slate-100">www.miegacoan.co.id</span>
                </div>
                <p class="text-[11px] text-white/90 drop-shadow-md font-medium">
                    *Selama persediaan masih ada. S&amp;K Berlaku. Gambar hidangan sebagai media promosi.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- About Section (Asymmetric Editorial Layout with Store Photo) -->
<section class="py-20 lg:py-24 bg-white border-b border-slate-200 overflow-hidden" id="tentang">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            <!-- Left 5 Column: Store Photo & Brand Label -->
            <div data-animate="fadeInLeft" class="lg:col-span-5 space-y-5">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-slate-400 block font-heading mb-1.5">TENTANG KAMI</span>
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-900 font-heading leading-tight">Pengalaman Bersantap Modern &amp; Cita Rasa Otentik</h3>
                </div>

                <!-- Store Atmosphere Photo Card with Floating Badge -->
                <div class="card-luxury relative rounded-2xl overflow-hidden border border-slate-200/90 shadow-sm group">
                    <div class="relative h-64 sm:h-72 w-full overflow-hidden bg-slate-100">
                        <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1000&auto=format&fit=crop" alt="Suasana Restoran Mie Gacoan" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute bottom-0 inset-x-0 p-4 bg-gradient-to-t from-slate-950/85 via-slate-950/40 to-transparent text-white">
                            <p class="text-xs font-bold font-heading">Ruang Bersantap Nyaman</p>
                            <p class="text-[10px] text-slate-300">Konsep Dine-in Higienis dengan Dapur Terbuka</p>
                        </div>
                    </div>
                    <div class="p-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600">
                        <span class="font-medium text-[11px]">Sistem Pemesanan Terintegrasi</span>
                        <span class="text-[10px] font-bold text-rose-600 tracking-wider">ONLINE &bull; POS &bull; RESERVASI</span>
                    </div>

                    <!-- Subtle Floating Flagship Badge -->
                    <div class="animate-float absolute top-3 right-3 bg-slate-900/90 backdrop-blur-xs text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm">
                        Outlet Flagship
                    </div>
                </div>
            </div>

            <!-- Right 7 Column: Narrative & Stats -->
            <div data-animate="fadeInRight" data-delay="150" class="lg:col-span-7 space-y-8 lg:pt-2">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 leading-snug font-heading">
                    Menyajikan Kelezatan Tanpa Kompromi, Menghubungkan Setiap Momen Kebersamaan di Seluruh Nusantara.
                </h2>

                <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                    Kami percaya bahwa makanan lezat dan higienis adalah hak setiap orang. Berawal dari kecintaan terhadap kuliner mie tradisional, Mie Gacoan berkembang menjadi ruang berkumpul yang nyaman, menyajikan hidangan bercita rasa kuat yang konsisten di setiap cabang.
                </p>

                <div class="pt-2">
                    <a href="{{ route('menu.index') }}" class="btn-luxury link-anim inline-flex items-center text-sm font-bold text-rose-600 hover:text-rose-700 transition">
                        Jelajahi Menu Pilihan Kami &nbsp;&rarr;
                    </a>
                </div>

                <!-- Divider -->
                <div class="h-[1px] bg-slate-200 pt-0"></div>

                <!-- Achievement Stats (With Animated Counters) -->
                <div class="grid grid-cols-3 gap-6 pt-2">
                    <div>
                        <span data-count="100" data-prefix=">" data-suffix=" Juta" class="block text-2xl sm:text-3xl font-bold text-slate-900 font-heading">>100 Juta</span>
                        <span class="text-xs text-slate-500 font-medium mt-1 block">Porsi Terhidang</span>
                    </div>
                    <div>
                        <span data-count="150" data-prefix=">" class="block text-2xl sm:text-3xl font-bold text-slate-900 font-heading">>150</span>
                        <span class="text-xs text-slate-500 font-medium mt-1 block">Outlet Nasional</span>
                    </div>
                    <div>
                        <span data-count="100" data-suffix="%" class="block text-2xl sm:text-3xl font-bold text-slate-900 font-heading">100%</span>
                        <span class="text-xs text-slate-500 font-medium mt-1 block">Sertifikasi Halal</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Services / Categories (Editorial 01, 02, 03 Grid like KAI & Webcare) -->
<section class="py-20 bg-slate-50 border-b border-slate-200 overflow-hidden" id="layanan">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div data-animate="fadeInUp" class="mb-14">
            <span class="text-xs font-bold uppercase tracking-widest text-slate-400 block font-heading mb-2">KATEGORI UTAMA</span>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 font-heading">
                Layanan Kuliner Pilihan.
            </h2>
        </div>

        <div class="stagger-grid grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 01: Mie Olahan -->
            <article class="card-luxury bg-white rounded-xl border border-slate-200 overflow-hidden shadow-xs flex flex-col group">
                <div class="relative h-56 w-full overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1552611052-33e04de081de?q=80&w=800&auto=format&fit=crop" alt="Mie Pedas" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <span class="font-bold text-xs text-slate-400 tracking-wider">01</span>
                        <h3 class="text-lg font-bold text-slate-900 font-heading mt-1">Mie Pedas &amp; Gurih</h3>
                        <p class="text-xs text-slate-600 leading-relaxed mt-2">
                            Pilihan Mie Hompimpa (asin gurih), Mie Gacoan (manis pedas), dan Mie Suit (original) dengan tingkat kepedasan level 0 hingga 8.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100">
                        <a href="{{ route('menu.index', ['category' => 'mie']) }}" class="btn-luxury link-anim inline-flex text-xs font-bold text-rose-600 hover:text-rose-700 transition">
                            Lihat Menu Mie &nbsp;&rarr;
                        </a>
                    </div>
                </div>
            </article>

            <!-- Card 02: Dimsum -->
            <article class="card-luxury bg-white rounded-xl border border-slate-200 overflow-hidden shadow-xs flex flex-col group">
                <div class="relative h-56 w-full overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1496116218417-1a781b1c416c?q=80&w=800&auto=format&fit=crop" alt="Dimsum" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <span class="font-bold text-xs text-slate-400 tracking-wider">02</span>
                        <h3 class="text-lg font-bold text-slate-900 font-heading mt-1">Dimsum &amp; Kudapan</h3>
                        <p class="text-xs text-slate-600 leading-relaxed mt-2">
                            Olahan udang dan ayam segar pilihan, mulai dari Udang Keju lumer, Udang Rambutan krispi, hingga Siomay kukus aromatik.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100">
                        <a href="{{ route('menu.index', ['category' => 'dimsum']) }}" class="btn-luxury link-anim inline-flex text-xs font-bold text-rose-600 hover:text-rose-700 transition">
                            Lihat Menu Dimsum &nbsp;&rarr;
                        </a>
                    </div>
                </div>
            </article>

            <!-- Card 03: Minuman -->
            <article class="card-luxury bg-white rounded-xl border border-slate-200 overflow-hidden shadow-xs flex flex-col group">
                <div class="relative h-56 w-full overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=800&auto=format&fit=crop" alt="Minuman Segar" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <span class="font-bold text-xs text-slate-400 tracking-wider">03</span>
                        <h3 class="text-lg font-bold text-slate-900 font-heading mt-1">Minuman Penawar Dahaga</h3>
                        <p class="text-xs text-slate-600 leading-relaxed mt-2">
                            Kombinasi susu, cincau segar, selasih, dan sirup buah tropis otentik yang dirancang khusus sebagai penawar rasa pedas.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100">
                        <a href="{{ route('menu.index', ['category' => 'minuman']) }}" class="btn-luxury link-anim inline-flex text-xs font-bold text-rose-600 hover:text-rose-700 transition">
                            Lihat Menu Minuman &nbsp;&rarr;
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- Bestsellers Menu (Clean, No Slop, Honest Pricing) -->
<section class="py-20 bg-white border-b border-slate-200 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div data-animate="fadeInUp" class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-slate-400 block font-heading mb-1">PILIHAN PELANGGAN</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 font-heading">Menu Andalan</h2>
            </div>
            <a href="{{ route('menu.index') }}" class="btn-luxury link-anim text-xs font-bold text-rose-600 hover:text-rose-700 transition">
                Buka Katalog Lengkap &nbsp;&rarr;
            </a>
        </div>

        <div class="stagger-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($popularProducts as $product)
            <div class="card-luxury bg-white rounded-xl border border-slate-200 p-4 flex gap-4 transition">
                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-24 h-24 object-cover rounded-lg bg-slate-100 flex-shrink-0 transition-transform duration-500 hover:scale-105">
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 font-heading">{{ $product->name }}</h4>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $product->description }}</p>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                        <span class="text-xs font-bold text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <button type="button" 
                                onclick='LuxuryModal.openProductCustomizer(@json($product))' 
                                class="btn-luxury btn-shimmer px-3 py-1.5 rounded-md bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition">
                            + Pesan
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- FAQ Accordion Section (Exact Architecture & Look of KAI Reference) -->
<section class="py-20 lg:py-24 bg-slate-50 border-b border-slate-200 overflow-hidden" id="faq">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Left Column -->
            <div data-animate="fadeInLeft" class="lg:col-span-4 space-y-4">
                <span class="text-xs font-bold uppercase tracking-widest text-slate-400 block font-heading">FAQ</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 leading-snug font-heading">
                    Jawaban untuk<br>Setiap Pertanyaan.
                </h2>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Temukan informasi penting seputar cara pemesanan, kustomisasi level hidangan, reservasi meja, dan metode pembayaran.
                </p>
            </div>

            <!-- Right Column: Clean Accordion -->
            <div data-animate="fadeInRight" data-delay="150" class="lg:col-span-8 space-y-3" role="list">
                <!-- FAQ 1 -->
                <div class="faq-item border border-slate-200 rounded-xl bg-white overflow-hidden transition-all duration-300 hover:border-slate-300">
                    <button type="button" class="faq-toggle w-full p-5 text-left flex items-center justify-between text-sm font-bold text-slate-900 font-heading hover:bg-slate-50 transition" onclick="toggleFaq(this)">
                        <span>Bagaimana cara memesan menu secara online?</span>
                        <span class="faq-arrow text-slate-400 text-xs transition-transform duration-200">&darr;</span>
                    </button>
                    <div class="faq-content hidden px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Anda dapat langsung memilih hidangan pada halaman menu, menentukan level kepedasan dan topping, lalu melanjutkan ke halaman checkout. Pesanan akan diteruskan langsung ke sistem antrean dapur.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="faq-item border border-slate-200 rounded-xl bg-white overflow-hidden transition-all duration-300 hover:border-slate-300">
                    <button type="button" class="faq-toggle w-full p-5 text-left flex items-center justify-between text-sm font-bold text-slate-900 font-heading hover:bg-slate-50 transition" onclick="toggleFaq(this)">
                        <span>Apakah saya bisa memesan menu tanpa rasa pedas?</span>
                        <span class="faq-arrow text-slate-400 text-xs transition-transform duration-200">&darr;</span>
                    </button>
                    <div class="faq-content hidden px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Ya. Kami menyediakan varian Mie Suit yang gurih aromatik tanpa cabai sama sekali (Level 0), serta pilihan aneka dimsum kukus dan goreng yang ramah untuk anak-anak maupun penikmat non-pedas.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="faq-item border border-slate-200 rounded-xl bg-white overflow-hidden transition-all duration-300 hover:border-slate-300">
                    <button type="button" class="faq-toggle w-full p-5 text-left flex items-center justify-between text-sm font-bold text-slate-900 font-heading hover:bg-slate-50 transition" onclick="toggleFaq(this)">
                        <span>Bagaimana alur reservasi meja untuk rombongan?</span>
                        <span class="faq-arrow text-slate-400 text-xs transition-transform duration-200">&darr;</span>
                    </button>
                    <div class="faq-content hidden px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Buka menu Reservasi Meja, pilih cabang yang dituju, tentukan tanggal serta jam kedatangan, dan pilih area (Indoor AC, Outdoor, atau VIP Room). Sistem akan mengonfirmasi ketersediaan meja secara instan.
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="faq-item border border-slate-200 rounded-xl bg-white overflow-hidden transition-all duration-300 hover:border-slate-300">
                    <button type="button" class="faq-toggle w-full p-5 text-left flex items-center justify-between text-sm font-bold text-slate-900 font-heading hover:bg-slate-50 transition" onclick="toggleFaq(this)">
                        <span>Metode pembayaran apa saja yang didukung?</span>
                        <span class="faq-arrow text-slate-400 text-xs transition-transform duration-200">&darr;</span>
                    </button>
                    <div class="faq-content hidden px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Kami mendukung pembayaran instan via QRIS (BCA, Mandiri, GoPay, OVO, ShopeePay), transfer virtual account, dan opsi pembayaran tunai langsung di kasir restoran.
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="faq-item border border-slate-200 rounded-xl bg-white overflow-hidden transition-all duration-300 hover:border-slate-300">
                    <button type="button" class="faq-toggle w-full p-5 text-left flex items-center justify-between text-sm font-bold text-slate-900 font-heading hover:bg-slate-50 transition" onclick="toggleFaq(this)">
                        <span>Apakah seluruh menu telah memiliki sertifikasi Halal?</span>
                        <span class="faq-arrow text-slate-400 text-xs transition-transform duration-200">&darr;</span>
                    </button>
                    <div class="faq-content hidden px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Seluruh bahan baku, bumbu racikan, hingga fasilitas pengolahan di seluruh cabang Mie Gacoan telah resmi tersertifikasi Halal oleh BPJPH Kementerian Agama RI.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bottom CTA Banner (Solid & Elegant like KAI & Webcare) -->
<section class="py-16 bg-slate-900 text-white overflow-hidden">
    <div data-animate="zoomIn" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-2">
            <p class="text-xs font-bold tracking-widest text-slate-400 uppercase font-heading">MULAI PESANAN ANDA</p>
            <h2 class="text-2xl sm:text-3xl font-bold font-heading">Hidangan Hangat Siap Tersaji di Meja Anda.</h2>
        </div>
        <a href="{{ route('menu.index') }}" class="btn-luxury btn-shimmer inline-flex items-center justify-center px-8 py-4 rounded-lg bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm transition shadow-sm">
            Pesan Sekarang &nbsp;&rarr;
        </a>
    </div>
</section>

@push('scripts')
<script>
    function toggleFaq(btn) {
        const item = btn.closest('.faq-item');
        const content = item.querySelector('.faq-content');
        const arrow = item.querySelector('.faq-arrow');

        const isOpened = !content.classList.contains('hidden');

        // Close all
        document.querySelectorAll('.faq-content').forEach(c => c.classList.add('hidden'));
        document.querySelectorAll('.faq-arrow').forEach(a => a.classList.remove('rotate-180'));

        if (!isOpened) {
            content.classList.remove('hidden');
            arrow.classList.add('rotate-180');
        }
    }
</script>
@endpush
@endsection
