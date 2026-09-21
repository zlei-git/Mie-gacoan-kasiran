@extends('layouts.app')

@section('title', 'Selesaikan Pesanan & Pembayaran - Mie Gacoan')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div data-animate="fadeInDown" class="mb-10 pb-6 border-b border-slate-200">
            <span class="text-xs font-bold uppercase tracking-widest text-slate-400 block font-heading mb-1">PROSES PEMBAYARAN</span>
            <h1 class="text-3xl font-bold text-slate-900 font-heading">Konfirmasi &amp; Checkout Pesanan</h1>
            <p class="text-slate-600 text-xs sm:text-sm mt-1">Lengkapi rincian pesanan dan pilih metode pembayaran resmi.</p>
        </div>

        @if($errors->any())
        <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-xs">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('checkout.store') }}" id="checkoutForm" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            @csrf
            <input type="hidden" name="items" id="checkoutItemsPayload">

            <!-- Left Form Area -->
            <div data-animate="fadeInLeft" class="lg:col-span-7 space-y-6">
                <!-- 1. Order Type Selection -->
                <div class="card-luxury bg-white p-6 rounded-xl border border-slate-200 space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 font-heading">
                        1. Tipe Layanan Pesanan
                    </h3>

                    <div class="grid grid-cols-3 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="order_type" value="pickup_now" checked class="sr-only peer" onchange="handleOrderTypeChange('pickup_now')">
                            <div class="p-3 text-center rounded-lg border border-slate-200 peer-checked:border-slate-900 peer-checked:bg-slate-50 transition">
                                <div class="text-xs font-bold text-slate-900">Bawa Pulang</div>
                                <div class="text-[10px] text-slate-500 mt-0.5">Ambil di Outlet</div>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="order_type" value="dine_in" class="sr-only peer" onchange="handleOrderTypeChange('dine_in')">
                            <div class="p-3 text-center rounded-lg border border-slate-200 peer-checked:border-slate-900 peer-checked:bg-slate-50 transition">
                                <div class="text-xs font-bold text-slate-900">Makan di Tempat</div>
                                <div class="text-[10px] text-slate-500 mt-0.5">Santap di Meja</div>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="order_type" value="delivery" class="sr-only peer" onchange="handleOrderTypeChange('delivery')">
                            <div class="p-3 text-center rounded-lg border border-slate-200 peer-checked:border-slate-900 peer-checked:bg-slate-50 transition">
                                <div class="text-xs font-bold text-slate-900">Pesan Antar</div>
                                <div class="text-[10px] text-slate-500 mt-0.5">COD / Delivery</div>
                            </div>
                        </label>
                    </div>

                    <!-- Single Official Store (No Multi-branch/PT selector) -->
                    <input type="hidden" name="branch_id" value="{{ $branches->first()->id ?? 1 }}">
                    <div class="p-3.5 bg-slate-50 rounded-lg border border-slate-200 text-xs flex items-center justify-between">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Toko / Outlet Resmi</span>
                            <span class="font-bold text-slate-900">Mie Gacoan Flagship Store</span>
                            <span class="text-slate-500 block text-[11px] mt-0.5">Jl. Raya Mulyosari No. 88, Surabaya</span>
                        </div>
                        <span class="text-[10px] font-bold px-2 py-0.5 bg-white border border-slate-200 text-slate-700 rounded">1 Toko Resmi</span>
                    </div>

                    <!-- Table Number (Only for Dine In) -->
                    <div id="tableSelectionContainer" class="hidden space-y-1 pt-1">
                        <label for="table_number" class="text-xs font-bold text-slate-700">Pilih Nomor Meja</label>
                        <select name="table_number" id="table_number" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:outline-none focus:border-slate-500 bg-white">
                            <option value="">-- Pilih Meja --</option>
                            @foreach($tables as $table)
                            <option value="{{ $table->table_number }}">Meja {{ $table->table_number }} ({{ $table->room }} &bull; Kapasitas {{ $table->capacity }} Orang)</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- 2. Customer Info -->
                <div class="card-luxury bg-white p-6 rounded-xl border border-slate-200 space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 font-heading">
                        2. Informasi Pemesan
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label for="customer_name" class="text-xs font-bold text-slate-700">Nama Lengkap</label>
                            <input type="text" name="customer_name" id="customer_name" value="{{ Auth::check() ? Auth::user()->name : old('customer_name') }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:outline-none focus:border-slate-500">
                        </div>

                        <div class="space-y-1">
                            <label for="customer_phone" class="text-xs font-bold text-slate-700">Nomor WhatsApp / HP</label>
                            <input type="tel" name="customer_phone" id="customer_phone" value="{{ Auth::check() ? Auth::user()->phone : old('customer_phone') }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:outline-none focus:border-slate-500">
                        </div>
                    </div>

                    <div class="space-y-1 pt-1">
                        <label for="notes" class="text-xs font-bold text-slate-700">Catatan Pesanan &amp; Alamat (Jika Diantar)</label>
                        <textarea name="notes" id="notes" rows="2" placeholder="Contoh: Alamat Jl. Mawar No. 12, Saus dipisah, kurangi kecap." class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:outline-none focus:border-slate-500"></textarea>
                    </div>
                </div>

                <!-- 3. Metode Pembayaran -->
                <div class="card-luxury bg-white p-6 rounded-xl border border-slate-200 space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 font-heading">
                        3. Metode Pembayaran
                    </h3>

                    <div class="space-y-2.5">
                        <label class="flex items-center justify-between p-3.5 rounded-lg border border-slate-200 hover:border-slate-300 cursor-pointer transition">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="qris" checked class="text-slate-900 focus:ring-slate-900">
                                <div>
                                    <div class="text-xs font-bold text-slate-900">QRIS (Semua E-Wallet &amp; Mobile Banking)</div>
                                    <div class="text-[11px] text-slate-500">GoPay, OVO, ShopeePay, BCA, Mandiri</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('images/qr/qris-stand.jpg') }}" alt="QRIS Stand" class="w-8 h-8 object-cover rounded border border-slate-200 shadow-2xs">
                                <span class="text-[10px] font-bold px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-200 rounded">Instan</span>
                            </div>
                        </label>

                        <!-- Dynamic Cash / COD Option -->
                        <label id="paymentMethodCashWrapper" class="flex items-center justify-between p-3.5 rounded-lg border border-slate-200 hover:border-slate-300 cursor-pointer transition">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="cash" id="paymentMethodCash" class="text-slate-900 focus:ring-slate-900">
                                <div>
                                    <div id="cashPaymentTitle" class="text-xs font-bold text-slate-900">Pembayaran Tunai di Kasir</div>
                                    <div id="cashPaymentSubtitle" class="text-[11px] text-slate-500">Bayar saat pengambilan atau di meja kasir restoran</div>
                                </div>
                            </div>
                            <span id="cashPaymentBadge" class="text-[10px] font-bold px-2 py-0.5 bg-slate-100 text-slate-700 rounded">Tunai</span>
                        </label>

                        <label class="flex items-center justify-between p-3.5 rounded-lg border border-slate-200 hover:border-slate-300 cursor-pointer transition">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="transfer" class="text-slate-900 focus:ring-slate-900">
                                <div>
                                    <div class="text-xs font-bold text-slate-900">Virtual Account Bank</div>
                                    <div class="text-[11px] text-slate-500">Transfer otomatis rekening bank</div>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold px-2 py-0.5 bg-slate-100 text-slate-700 rounded">VA</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div data-animate="fadeInRight" class="lg:col-span-5 space-y-6">
                <div class="card-luxury bg-white p-6 rounded-xl border border-slate-200 space-y-4 sticky top-28">
                    <h3 class="text-sm font-bold text-slate-900 font-heading pb-3 border-b border-slate-100 flex items-center justify-between">
                        <span>Ringkasan Menu</span>
                        <a href="{{ route('menu.index') }}" class="text-xs text-rose-600 hover:underline font-semibold">+ Tambah</a>
                    </h3>

                    <div id="checkoutItemsList" class="space-y-2 max-h-60 overflow-y-auto pr-1"></div>

                    <!-- Voucher -->
                    <div class="pt-3 border-t border-slate-100 space-y-1.5">
                        <label for="promo_code" class="text-xs font-bold text-slate-700">Kode Voucher Diskon</label>
                        <div class="flex gap-2">
                            <input type="text" name="promo_code" id="promo_code" placeholder="GACOANHEMAT" class="flex-1 px-3 py-1.5 text-xs font-bold tracking-wider uppercase rounded-lg border border-slate-300 focus:outline-none focus:border-slate-500">
                            <button type="button" onclick="applyPromoCode()" class="btn-luxury px-3.5 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold">Terapkan</button>
                        </div>
                        <div id="promoMessage" class="text-[11px] hidden font-semibold"></div>
                    </div>

                    <!-- Totals -->
                    <div class="pt-3 border-t border-slate-100 space-y-1 text-xs text-slate-600">
                        <div class="flex justify-between">
                            <span>Subtotal Menu</span>
                            <span id="summarySubtotal" class="font-bold text-slate-900">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-emerald-600 hidden" id="summaryDiscountRow">
                            <span>Diskon Voucher</span>
                            <span id="summaryDiscount" class="font-bold">-Rp 0</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Pajak Restoran (PB1 10%)</span>
                            <span id="summaryTax" class="font-medium text-slate-500">Rp 0</span>
                        </div>
                        <div class="pt-2 border-t border-slate-200 flex justify-between items-center text-sm font-bold text-slate-900">
                            <span>Total Tagihan</span>
                            <span id="summaryTotal" class="text-base font-bold font-heading text-slate-900">Rp 0</span>
                        </div>
                    </div>

                    <button type="submit" id="btnSubmitOrder" class="btn-luxury btn-shimmer w-full py-3 px-4 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition text-center">
                        Konfirmasi Pesanan &nbsp;&rarr;
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function toggleTableSelection(isDineIn) {
        const container = document.getElementById('tableSelectionContainer');
        const select = document.getElementById('table_number');
        if (isDineIn) {
            container.classList.remove('hidden');
            select.setAttribute('required', 'required');
        } else {
            container.classList.add('hidden');
            select.removeAttribute('required');
            select.value = '';
        }
    }

    function handleOrderTypeChange(type) {
        const isDineIn = type === 'dine_in';
        const isDelivery = type === 'delivery';

        toggleTableSelection(isDineIn);

        const titleEl = document.getElementById('cashPaymentTitle');
        const subEl = document.getElementById('cashPaymentSubtitle');
        const badgeEl = document.getElementById('cashPaymentBadge');

        if (isDelivery) {
            if (titleEl) titleEl.textContent = 'COD (Bayar Tunai di Tempat)';
            if (subEl) subEl.textContent = 'Bayar langsung dengan uang pas kepada kurir saat pesanan sampai di alamat Anda';
            if (badgeEl) {
                badgeEl.textContent = 'COD';
                badgeEl.className = 'text-[10px] font-bold px-2 py-0.5 bg-rose-50 text-rose-700 rounded border border-rose-200';
            }
        } else {
            if (titleEl) titleEl.textContent = 'Pembayaran Tunai di Kasir Outlet';
            if (subEl) subEl.textContent = 'Bayar tunai di loket kasir saat pesanan disiapkan atau diambil';
            if (badgeEl) {
                badgeEl.textContent = 'Kasir';
                badgeEl.className = 'text-[10px] font-bold px-2 py-0.5 bg-slate-100 text-slate-700 rounded';
            }
        }
    }

    let activeDiscount = 0;

    function renderCheckoutItems() {
        const items = Cart.getItems();
        const container = document.getElementById('checkoutItemsList');
        const payloadInput = document.getElementById('checkoutItemsPayload');
        const submitBtn = document.getElementById('btnSubmitOrder');

        if (!container || !payloadInput) return;

        if (items.length === 0) {
            container.innerHTML = `
                <div class="text-center py-6">
                    <p class="text-xs text-slate-500">Keranjang pesanan kosong.</p>
                    <a href="{{ route('menu.index') }}" class="inline-block mt-2 text-xs font-bold text-rose-600 underline">Pilih Menu &rarr;</a>
                </div>
            `;
            if (submitBtn) submitBtn.disabled = true;
            payloadInput.value = '';
            return;
        }

        if (submitBtn) submitBtn.disabled = false;
        payloadInput.value = JSON.stringify(items);

        let html = '';
        items.forEach(item => {
            const spicy = item.spicy_level !== null ? `<span class="text-[10px] px-1.5 py-0.2 bg-slate-100 text-slate-700 rounded font-semibold">Lv. ${item.spicy_level}</span>` : '';
            html += `
                <div class="flex items-center justify-between text-xs py-2 border-b border-slate-100 last:border-0">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-slate-700">${item.quantity}x</span>
                        <div>
                            <p class="font-bold text-slate-900">${item.name}</p>
                            <div class="flex items-center gap-1.5 text-slate-500 mt-0.5">
                                ${spicy}
                                ${item.addons ? `<span class="text-[10px] text-slate-400">+ ${item.addons}</span>` : ''}
                            </div>
                        </div>
                    </div>
                    <span class="font-bold text-slate-900">Rp ${(item.price * item.quantity).toLocaleString('id-ID')}</span>
                </div>
            `;
        });
        container.innerHTML = html;

        calculateTotals();
    }

    function calculateTotals() {
        const subtotal = Cart.getSubtotal();
        const discountRow = document.getElementById('summaryDiscountRow');
        const discountEl = document.getElementById('summaryDiscount');

        let discount = activeDiscount;
        if (discount > subtotal) discount = subtotal;

        if (discount > 0) {
            discountRow.classList.remove('hidden');
            discountEl.textContent = '-Rp ' + discount.toLocaleString('id-ID');
        } else {
            discountRow.classList.add('hidden');
        }

        const tax = Math.round((subtotal - discount) * 0.10);
        const total = Math.max(0, subtotal - discount + tax);

        document.getElementById('summarySubtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        document.getElementById('summaryTax').textContent = 'Rp ' + tax.toLocaleString('id-ID');
        document.getElementById('summaryTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    function applyPromoCode() {
        const code = document.getElementById('promo_code').value.trim().toUpperCase();
        const msgEl = document.getElementById('promoMessage');
        msgEl.classList.remove('hidden');

        const subtotal = Cart.getSubtotal();

        if (code === 'GACOANHEMAT') {
            if (subtotal < 25000) {
                msgEl.className = 'text-[11px] text-amber-600 font-semibold';
                msgEl.textContent = 'Minimal pembelian Rp 25.000 untuk menggunakan voucher ini.';
                activeDiscount = 0;
            } else {
                activeDiscount = Math.round(subtotal * 0.20);
                msgEl.className = 'text-[11px] text-emerald-600 font-semibold';
                msgEl.textContent = 'Voucher diterapkan: Diskon 20%.';
            }
        } else if (code === 'ANTIRIBET5K') {
            if (subtotal < 30000) {
                msgEl.className = 'text-[11px] text-amber-600 font-semibold';
                msgEl.textContent = 'Minimal pembelian Rp 30.000 untuk menggunakan voucher ini.';
                activeDiscount = 0;
            } else {
                activeDiscount = 5000;
                msgEl.className = 'text-[11px] text-emerald-600 font-semibold';
                msgEl.textContent = 'Voucher diterapkan: Potongan Rp 5.000.';
            }
        } else {
            msgEl.className = 'text-[11px] text-red-600 font-semibold';
            msgEl.textContent = 'Kode voucher tidak valid.';
            activeDiscount = 0;
        }

        calculateTotals();
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderCheckoutItems();
        if (Cart.getItems().length === 0) {
            Cart.showWarningToast('Mohon tambahkan item terlebih dahulu');
        }
        document.getElementById('checkoutForm')?.addEventListener('submit', (e) => {
            if (Cart.getItems().length === 0) {
                e.preventDefault();
                Cart.showWarningToast('Mohon tambahkan item terlebih dahulu');
                return false;
            }
            setTimeout(() => Cart.clear(), 500);
        });
    });
</script>
@endpush
@endsection
