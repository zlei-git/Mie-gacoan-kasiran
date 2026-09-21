@extends('layouts.app')

@section('title', 'Status Pesanan #' . $order->order_code)

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Header -->
        <div data-animate="fadeInDown" class="card-luxury bg-white p-6 sm:p-8 rounded-xl border border-slate-200 text-center space-y-2">
            <span class="text-[11px] font-bold tracking-widest text-slate-400 uppercase font-heading">STATUS LAYANAN</span>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 font-heading">Pelacakan Pesanan</h1>
            <p class="text-slate-500 text-xs">Kode Order: <strong class="text-slate-900 text-sm font-bold tracking-wider">{{ $order->order_code }}</strong></p>
        </div>

        <!-- Stepper (Clean Numbered 01 - 04, No Emojis) -->
        <div data-animate="fadeInUp" data-delay="100" class="card-luxury bg-white p-6 sm:p-8 rounded-xl border border-slate-200 space-y-6">
            @php
                $statusMap = [
                    'pending_payment' => 1,
                    'in_kitchen' => 2,
                    'ready_pickup' => 3,
                    'completed' => 4,
                ];
                $currentStep = $statusMap[$order->status] ?? 2;
            @endphp

            <div class="grid grid-cols-4 gap-2 text-center text-xs">
                <!-- Step 1 -->
                <div class="flex flex-col items-center space-y-1.5">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold {{ $currentStep >= 1 ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-400' }}">
                        01
                    </div>
                    <span class="font-semibold {{ $currentStep >= 1 ? 'text-slate-900' : 'text-slate-400' }}">Diterima</span>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center space-y-1.5">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold {{ $currentStep >= 2 ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-400' }}">
                        02
                    </div>
                    <span class="font-semibold {{ $currentStep >= 2 ? 'text-slate-900' : 'text-slate-400' }}">Di Dapur</span>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center space-y-1.5">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold {{ $currentStep >= 3 ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-400' }}">
                        03
                    </div>
                    <span class="font-semibold {{ $currentStep >= 3 ? 'text-slate-900' : 'text-slate-400' }}">Siap Saji</span>
                </div>

                <!-- Step 4 -->
                <div class="flex flex-col items-center space-y-1.5">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold {{ $currentStep >= 4 ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-400' }}">
                        04
                    </div>
                    <span class="font-semibold {{ $currentStep >= 4 ? 'text-slate-900' : 'text-slate-400' }}">Selesai</span>
                </div>
            </div>

            <!-- Current Stage Callout -->
            <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 text-xs text-slate-700">
                <strong class="block font-bold text-sm text-slate-900 font-heading">
                    @if($order->status === 'in_kitchen') Pesanan sedang disiapkan di dapur restoran
                    @elseif($order->status === 'ready_pickup') Pesanan sudah siap saji. Silakan tunjukkan QR di kasir / pickup counter
                    @elseif($order->status === 'completed') Pesanan telah selesai disajikan. Terima kasih.
                    @else Menunggu konfirmasi pembayaran
                    @endif
                </strong>
                <span class="text-slate-500 mt-0.5 block">Estimasi waktu penyiapan rata-rata 10 - 15 menit.</span>
            </div>
        </div>

        <!-- Order & Pickup QR Details -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            <!-- QR Box -->
            <div data-animate="fadeInLeft" data-delay="150" class="md:col-span-4 card-luxury bg-white p-6 rounded-xl border border-slate-200 text-center flex flex-col items-center justify-center space-y-3">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-heading">Kode Pengambilan</span>
                <div class="p-2.5 bg-white border border-slate-200 rounded-xl shadow-xs group">
                    <img src="{{ asset('images/qr/order-pickup-qr.jpg') }}" alt="QR Code Pengambilan #{{ $order->order_code }}" class="w-36 h-36 mx-auto object-contain rounded-lg transition-transform duration-300 group-hover:scale-105">
                </div>
                <div class="space-y-1">
                    <span class="inline-block text-xs font-bold text-slate-900 bg-slate-100 px-3 py-1 rounded-full border border-slate-200 tracking-wider">
                        {{ $order->order_code }}
                    </span>
                    <p class="text-[11px] text-slate-400">Tunjukkan kode ini kepada petugas saat mengambil pesanan.</p>
                </div>

                @if($order->payment_method === 'qris')
                <div class="pt-3 border-t border-slate-100 w-full">
                    <button type="button" onclick="document.getElementById('qrisCustomerModal').classList.remove('hidden')" class="btn-luxury w-full py-2 px-3 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-[11px] border border-rose-200 flex items-center justify-center gap-1.5 transition">
                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        Lihat Stand QRIS Pembayaran
                    </button>
                </div>
                @endif
            </div>

            <!-- Items Breakdown -->
            <div data-animate="fadeInRight" data-delay="150" class="md:col-span-8 card-luxury bg-white p-6 sm:p-8 rounded-xl border border-slate-200 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-900 font-heading">Rincian Hidangan</h3>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded bg-slate-100 text-slate-700 capitalize">
                        {{ str_replace('_', ' ', $order->order_type) }}
                        @if($order->table_number) &bull; Meja {{ $order->table_number }} @endif
                    </span>
                </div>

                <div class="space-y-2">
                    @foreach($order->items as $item)
                    <div class="flex items-center justify-between text-xs py-1 border-b border-slate-50 last:border-0">
                        <div>
                            <span class="font-bold text-slate-900">{{ $item['quantity'] ?? 1 }}x {{ $item['name'] }}</span>
                            <div class="text-[11px] text-slate-500 mt-0.5">
                                @if(isset($item['spicy_level']) && $item['spicy_level'] !== null)
                                    <span>Level {{ $item['spicy_level'] }}</span>
                                @endif
                                @if(!empty($item['addons']))
                                    <span>&bull; + {{ $item['addons'] }}</span>
                                @endif
                            </div>
                        </div>
                        <span class="font-bold text-slate-800">
                            Rp {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 0, ',', '.') }}
                        </span>
                    </div>
                    @endforeach
                </div>

                <div class="pt-3 border-t border-slate-100 space-y-1 text-xs text-slate-600">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span class="font-semibold text-slate-800">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @if($order->discount > 0)
                    <div class="flex justify-between text-emerald-600 font-semibold">
                        <span>Diskon</span>
                        <span class="font-semibold text-emerald-600">-Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span>Pajak (PB1 10%)</span>
                        <span class="font-semibold text-slate-800">Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="pt-2 border-t border-slate-200 flex justify-between items-center text-sm font-bold text-slate-900">
                        <span>Total</span>
                        <span class="text-base font-bold font-heading">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="p-3 rounded-lg bg-slate-50 border border-slate-200 text-xs text-slate-600">
                    <div>Outlet: <strong class="text-slate-800">{{ $order->branch->name ?? 'Mulyosari' }}</strong></div>
                    <div class="text-[11px] text-slate-400 mt-0.5">{{ $order->branch->address ?? 'Surabaya' }} &bull; {{ $order->branch->phone ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="text-center pt-2">
            <a href="{{ route('menu.index') }}" class="btn-luxury inline-block px-5 py-2.5 rounded-lg bg-slate-900 text-white font-semibold text-xs hover:bg-slate-800 transition">
                &larr; Kembali ke Menu
            </a>
        </div>
    </div>
</div>

@if($order->payment_method === 'qris')
<!-- Modal QRIS Customer -->
<div id="qrisCustomerModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm" onclick="document.getElementById('qrisCustomerModal').classList.add('hidden')"></div>
    <div class="min-h-screen px-4 flex items-center justify-center">
        <div class="relative bg-white border border-slate-200 rounded-2xl p-6 max-w-sm w-full space-y-4 text-center shadow-2xl">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-900 font-heading">QRIS Pembayaran Resmi</h3>
                <button type="button" onclick="document.getElementById('qrisCustomerModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-700 font-bold text-base">&times;</button>
            </div>
            
            <div class="p-2 bg-slate-50 border border-slate-200 rounded-xl">
                <img src="{{ asset('images/qr/qris-stand.jpg') }}" alt="QRIS Stand Mie Gacoan" class="w-full max-w-[260px] mx-auto object-contain rounded-lg shadow-xs">
            </div>

            <div class="space-y-1">
                <span class="text-xs text-slate-500 block">Total Tagihan:</span>
                <span class="text-xl font-bold font-heading text-rose-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                <p class="text-[11px] text-slate-500 pt-1">Buka aplikasi mobile banking atau e-wallet (BCA, Mandiri, GoPay, OVO, ShopeePay) lalu scan kode di atas.</p>
            </div>

            <button type="button" onclick="document.getElementById('qrisCustomerModal').classList.add('hidden')" class="btn-luxury w-full py-2.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition">
                Tutup Jendela
            </button>
        </div>
    </div>
</div>
@endif
@endsection
