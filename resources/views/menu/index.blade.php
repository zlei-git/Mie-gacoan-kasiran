@extends('layouts.app')

@section('title', 'Katalog Menu & Harga - Mie Gacoan')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Search -->
        <div data-animate="fadeInDown" class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10 pb-6 border-b border-slate-200">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-slate-400 block font-heading mb-1">DAFTAR HIDANGAN</span>
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 font-heading">Menu Spesial Mie Gacoan</h1>
                <p class="text-slate-600 text-xs sm:text-sm mt-1">Pilihan mie pedas olahan, dimsum renyah, dan minuman segar penawar pedas.</p>
            </div>

            <!-- Search Form -->
            <form method="GET" action="{{ route('menu.index') }}" class="flex items-center gap-2 max-w-sm w-full">
                <input type="hidden" name="category" value="{{ $category }}">
                <div class="relative flex-1">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama hidangan..." class="w-full pl-9 pr-3 py-2 rounded-lg border border-slate-300 bg-white text-xs focus:outline-none focus:border-slate-500">
                    <svg class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <button type="submit" class="btn-luxury px-4 py-2 rounded-lg bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold transition">
                    Cari
                </button>
            </form>
        </div>

        <!-- Category Tabs (Clean Text without Emojis) -->
        <div data-animate="fadeInUp" data-delay="100" class="flex items-center gap-2 overflow-x-auto pb-4 mb-8">
            @foreach($categories as $cat)
            <a href="{{ route('menu.index', ['category' => $cat['id'], 'q' => $search]) }}" 
               class="btn-luxury px-4 py-2 rounded-lg text-xs font-semibold whitespace-nowrap transition border {{ $category === $cat['id'] ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-100' }}">
                {{ $cat['name'] }}
            </a>
            @endforeach
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
        <div class="stagger-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="card-luxury bg-white rounded-xl border border-slate-200 overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="relative h-48 w-full bg-slate-100 overflow-hidden group">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @if($product->has_spicy_level)
                        <span class="absolute top-3 left-3 bg-slate-900/90 text-white text-[10px] font-bold tracking-wide px-2 py-0.5 rounded">
                            Level 0-{{ $product->max_spicy_level }}
                        </span>
                        @endif
                    </div>

                    <div class="p-4 space-y-1.5">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">{{ ucfirst($product->category) }}</span>
                        <h3 class="text-sm font-bold text-slate-900 font-heading">{{ $product->name }}</h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $product->description }}</p>
                    </div>
                </div>

                <div class="p-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-slate-400 block">Harga Satuan</span>
                        <span class="text-sm font-bold text-slate-900 font-heading">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    <button type="button" 
                            onclick='LuxuryModal.openProductCustomizer(@json($product))' 
                            class="btn-luxury btn-shimmer px-3.5 py-1.5 rounded-md bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition">
                        + Pesan
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-20 bg-white rounded-xl border border-slate-200">
            <h3 class="text-sm font-bold text-slate-800">Menu Tidak Ditemukan</h3>
            <p class="text-xs text-slate-500 mt-1">Coba kata kunci pencarian lain atau tampilkan seluruh menu.</p>
            <a href="{{ route('menu.index') }}" class="inline-block mt-3 px-3.5 py-1.5 rounded-lg bg-slate-900 text-white text-xs font-semibold">
                Tampilkan Semua
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
