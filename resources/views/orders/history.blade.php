@extends('layouts.app')

@section('title', 'Riwayat Pesanan - Mie Gacoan')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-6 border-b border-slate-200">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-slate-400 block font-heading mb-1">DATA TRANSAKSI</span>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Riwayat Pesanan Pelanggan</h1>
                <p class="text-slate-600 text-xs sm:text-sm mt-1">Daftar transaksi dan hidangan yang pernah Anda pesan sebelumnya.</p>
            </div>
            <a href="{{ route('menu.index') }}" class="px-4 py-2 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition inline-block text-center">
                + Pesan Menu Baru
            </a>
        </div>

        @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
            <div class="bg-white p-6 rounded-xl border border-slate-200 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-100 text-xs">
                    <div class="flex items-center gap-3">
                        <span class="font-mono font-bold text-slate-900 bg-slate-100 px-2.5 py-1 rounded">#{{ $order->order_code }}</span>
                        <span class="text-slate-400">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>

                    <div>
                        @if($order->status === 'completed')
                            <span class="px-2.5 py-0.5 rounded text-[11px] font-semibold bg-emerald-100 text-emerald-800">Selesai</span>
                        @elseif($order->status === 'ready_pickup')
                            <span class="px-2.5 py-0.5 rounded text-[11px] font-semibold bg-amber-100 text-amber-800">Siap Ambil</span>
                        @else
                            <span class="px-2.5 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-800">Di Dapur</span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <div class="md:col-span-8 text-xs space-y-1">
                        <div class="font-bold text-slate-900">
                            {{ count($order->items) }} Menu Dipesan: 
                            {{ collect($order->items)->pluck('name')->implode(', ') }}
                        </div>
                        <div class="text-slate-500 text-[11px]">
                            Outlet: {{ $order->branch->name ?? 'Surabaya' }} &bull; Tipe: {{ str_replace('_', ' ', $order->order_type) }}
                        </div>
                    </div>

                    <div class="md:col-span-4 flex items-center justify-between md:justify-end gap-4 pt-2 md:pt-0 border-t md:border-t-0 border-slate-100">
                        <div class="text-left md:text-right">
                            <span class="text-[10px] text-slate-400 block">Total Pembayaran</span>
                            <span class="text-sm font-bold text-slate-900 font-mono">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('orders.track', ['code' => $order->order_code]) }}" class="px-3.5 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs transition">
                            Status &rarr;
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pt-2">
            {{ $orders->links() }}
        </div>
        @else
        <div class="text-center py-20 bg-white rounded-xl border border-slate-200 space-y-3">
            <h3 class="text-sm font-bold text-slate-900 font-heading">Belum Ada Riwayat Pesanan</h3>
            <p class="text-xs text-slate-500 max-w-sm mx-auto">Anda belum memiliki riwayat transaksi pemesanan. Pilih hidangan pilihan Anda di halaman katalog menu.</p>
            <div class="pt-2">
                <a href="{{ route('menu.index') }}" class="px-4 py-2 rounded-lg bg-slate-900 text-white font-semibold text-xs hover:bg-slate-800 transition inline-block">
                    Lihat Menu &rarr;
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
