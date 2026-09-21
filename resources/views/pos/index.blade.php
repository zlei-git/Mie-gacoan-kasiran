@extends('layouts.pos')

@section('content')
<!-- Left: Fast Catalog Area -->
<div class="flex-1 flex flex-col bg-stone-900 border-r border-stone-800 overflow-hidden">
    <!-- Filters & Search Toolbar -->
    <div class="p-4 border-b border-stone-800 flex flex-wrap items-center justify-between gap-3 bg-stone-900/50">
        <!-- Category Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">
            <button type="button" onclick="filterPosCategory('all')" class="pos-cat-btn px-4 py-2 rounded-xl text-xs font-bold bg-rose-600 text-white transition active:scale-95" data-cat="all">
                Semua
            </button>
            <button type="button" onclick="filterPosCategory('mie')" class="pos-cat-btn px-4 py-2 rounded-xl text-xs font-bold bg-stone-800 text-stone-300 hover:bg-stone-700 transition active:scale-95" data-cat="mie">
                Mie Pedas
            </button>
            <button type="button" onclick="filterPosCategory('dimsum')" class="pos-cat-btn px-4 py-2 rounded-xl text-xs font-bold bg-stone-800 text-stone-300 hover:bg-stone-700 transition active:scale-95" data-cat="dimsum">
                Dimsum
            </button>
            <button type="button" onclick="filterPosCategory('minuman')" class="pos-cat-btn px-4 py-2 rounded-xl text-xs font-bold bg-stone-800 text-stone-300 hover:bg-stone-700 transition active:scale-95" data-cat="minuman">
                Minuman
            </button>
        </div>

        <!-- Fast Search & Offline Toggle Simulator -->
        <div class="flex items-center gap-2">
            <div class="relative">
                <input type="text" id="posSearch" placeholder="Ketik nama menu..." oninput="searchPosProducts()" class="pl-8 pr-3 py-1.5 rounded-xl bg-stone-800 text-white text-xs border border-stone-700 focus:outline-none focus:border-rose-500 w-44">
                <svg class="w-3.5 h-3.5 text-stone-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <!-- Toggle Offline Simulation -->
            <button type="button" onclick="toggleSimulatedOffline()" id="btnSimOffline" class="px-3 py-1.5 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-300 text-xs font-semibold border border-stone-700" title="Uji Coba Simpan Offline">
                Mode: Online
            </button>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="flex-1 overflow-y-auto p-4">
        <div id="posProductGrid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
            @foreach($products as $p)
            <button type="button" 
                    onclick='addPosItem(@json($p))'
                    class="pos-card text-left bg-stone-800/80 hover:bg-stone-800 border border-stone-700/80 hover:border-rose-500/80 p-3 rounded-2xl flex flex-col justify-between transition-all duration-150 active:scale-95 group shadow-sm"
                    data-category="{{ $p->category }}"
                    data-name="{{ strtolower($p->name) }}">
                <div class="space-y-2">
                    <div class="relative h-24 w-full rounded-xl overflow-hidden bg-stone-700">
                        <img src="{{ $p->image }}" alt="{{ $p->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @if($p->has_spicy_level)
                        <span class="absolute top-1.5 left-1.5 bg-rose-600 text-white text-[9px] font-black px-1.5 py-0.5 rounded shadow">
                            Lv 0-{{ $p->max_spicy_level }}
                        </span>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-white line-clamp-1 group-hover:text-rose-400">{{ $p->name }}</h4>
                        <span class="text-[10px] text-stone-400">{{ ucfirst($p->category) }}</span>
                    </div>
                </div>
                <div class="pt-2 mt-1 border-t border-stone-700/50 flex items-center justify-between">
                    <span class="text-xs font-extrabold text-amber-400">Rp {{ number_format($p->price, 0, ',', '.') }}</span>
                    <span class="w-5 h-5 rounded-lg bg-stone-700 group-hover:bg-rose-600 text-white text-xs flex items-center justify-center font-bold">+</span>
                </div>
            </button>
            @endforeach
        </div>
    </div>
</div>

<!-- Right: Active Order Ticket Area -->
<div class="w-96 lg:w-[420px] bg-stone-950 flex flex-col overflow-hidden border-l border-stone-800">
    <!-- Ticket Header & Order Type -->
    <div class="p-4 border-b border-stone-800 space-y-3 bg-stone-900/30">
        <div class="flex items-center justify-between">
            <span class="text-xs font-extrabold text-white uppercase tracking-wider">
                Tiket Pesanan Aktif
            </span>
            <button type="button" onclick="clearPosTicket()" class="text-[11px] text-stone-500 hover:text-red-400 transition font-semibold">
                Reset Tiket
            </button>
        </div>

        <!-- Order Type Toggle -->
        <div class="grid grid-cols-2 gap-2 text-xs">
            <button type="button" onclick="setPosOrderType('dine_in')" id="btnDineIn" class="py-2 px-3 rounded-xl font-bold bg-rose-600 text-white border border-rose-500 transition">
                Makan di Tempat
            </button>
            <button type="button" onclick="setPosOrderType('takeaway')" id="btnTakeaway" class="py-2 px-3 rounded-xl font-bold bg-stone-800 text-stone-400 border border-stone-700 hover:bg-stone-700 transition">
                Bawa Pulang
            </button>
        </div>

        <!-- Customer & Table Selectors -->
        <div class="grid grid-cols-2 gap-2 text-xs">
            <input type="text" id="posCustomerName" placeholder="Nama Pelanggan" value="Pelanggan Kasir" class="px-3 py-2 rounded-xl bg-stone-900 border border-stone-700 text-white focus:outline-none focus:border-rose-500">
            <select id="posTableNumber" class="px-3 py-2 rounded-xl bg-stone-900 border border-stone-700 text-white focus:outline-none focus:border-rose-500">
                <option value="">-- Meja --</option>
                @foreach($tables as $t)
                <option value="{{ $t->table_number }}">{{ $t->table_number }} ({{ $t->room }})</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Ticket Items List -->
    <div class="flex-1 overflow-y-auto p-4 space-y-2" id="posTicketItemsContainer">
        <div id="posTicketEmpty" class="text-center py-20 text-stone-600 text-xs">
            Belum ada menu yang dipilih.<br>Klik menu di sebelah kiri untuk menambahkan.
        </div>
        <div id="posTicketItemsList" class="space-y-2"></div>
    </div>

    <!-- Ticket Calculations & Payment Panel -->
    <div class="p-4 border-t border-stone-800 bg-stone-900/60 space-y-3">
        <!-- Discount Buttons -->
        <div class="flex items-center justify-between text-xs">
            <span class="text-stone-400">Diskon:</span>
            <div class="flex gap-1.5">
                <button type="button" onclick="setPosDiscount(0)" class="pos-disc-btn px-2.5 py-1 rounded-lg bg-stone-800 text-stone-300 text-[11px] font-bold">0</button>
                <button type="button" onclick="setPosDiscount(5000)" class="pos-disc-btn px-2.5 py-1 rounded-lg bg-stone-800 text-stone-300 text-[11px] font-bold">-5rb</button>
                <button type="button" onclick="setPosDiscount(10000)" class="pos-disc-btn px-2.5 py-1 rounded-lg bg-stone-800 text-stone-300 text-[11px] font-bold">-10rb</button>
            </div>
        </div>

        <!-- Breakdown -->
        <div class="space-y-1 text-xs text-stone-400">
            <div class="flex justify-between">
                <span>Subtotal Menu</span>
                <span id="posSubtotalText" class="font-mono text-white">Rp 0</span>
            </div>
            <div class="flex justify-between text-emerald-400 hidden" id="posDiscountRow">
                <span>Potongan Diskon</span>
                <span id="posDiscountText" class="font-mono">-Rp 0</span>
            </div>
            <div class="flex justify-between">
                <span>PB1 Restoran (10%)</span>
                <span id="posTaxText" class="font-mono text-stone-400">Rp 0</span>
            </div>
            <div class="pt-2 border-t border-stone-800 flex justify-between items-center text-sm font-bold text-white">
                <span>Total Bayar</span>
                <span id="posTotalText" class="text-lg font-mono font-extrabold text-amber-400">Rp 0</span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="grid grid-cols-2 gap-2 pt-1">
            <button type="button" onclick="openCashPaymentModal()" class="py-3 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center justify-center gap-1.5 transition active:scale-95">
                Bayar Tunai
            </button>
            <button type="button" onclick="openQrisPaymentModal()" class="py-3 px-3 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs flex items-center justify-center gap-1.5 transition active:scale-95">
                QRIS Instan
            </button>
        </div>
    </div>
</div>

<!-- Modal: Bayar Tunai & Kembalian -->
<div id="cashModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" onclick="closeCashModal()"></div>
    <div class="min-h-screen px-4 flex items-center justify-center">
        <div class="relative bg-stone-900 border border-stone-800 rounded-3xl p-6 max-w-sm w-full space-y-5 text-white shadow-2xl">
            <h3 class="text-base font-bold flex items-center justify-between pb-3 border-b border-stone-800">
                <span>Pembayaran Tunai</span>
                <button type="button" onclick="closeCashModal()" class="text-stone-400 hover:text-white">✕</button>
            </h3>

            <div class="space-y-1">
                <span class="text-xs text-stone-400">Total Tagihan:</span>
                <div id="cashModalTotal" class="text-2xl font-mono font-black text-amber-400">Rp 0</div>
            </div>

            <!-- Fast Cash Buttons -->
            <div class="space-y-1.5">
                <span class="text-xs text-stone-400">Pilihan Cepat Uang Diterima:</span>
                <div class="grid grid-cols-3 gap-2 text-xs font-mono font-bold">
                    <button type="button" onclick="setCashReceived('exact')" class="p-2.5 rounded-xl bg-stone-800 hover:bg-stone-700 border border-stone-700">Uang Pas</button>
                    <button type="button" onclick="setCashReceived(50000)" class="p-2.5 rounded-xl bg-stone-800 hover:bg-stone-700 border border-stone-700">50.000</button>
                    <button type="button" onclick="setCashReceived(100000)" class="p-2.5 rounded-xl bg-stone-800 hover:bg-stone-700 border border-stone-700">100.000</button>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-xs text-stone-400">Uang Diterima (Rp):</label>
                <input type="number" id="cashReceivedInput" oninput="calculateChange()" class="w-full px-3.5 py-2.5 rounded-xl bg-stone-800 border border-stone-700 text-white font-mono text-lg font-bold focus:outline-none focus:border-emerald-500">
            </div>

            <div class="p-3 rounded-2xl bg-stone-800/80 border border-stone-700 flex items-center justify-between">
                <span class="text-xs text-stone-400">Kembalian:</span>
                <span id="cashChangeText" class="text-lg font-mono font-bold text-emerald-400">Rp 0</span>
            </div>

            <button type="button" onclick="processPosOrder('cash')" class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition">
                Selesaikan Transaksi & Cetak Struk
            </button>
        </div>
    </div>
</div>

<!-- Modal: QRIS Pop-up -->
<div id="qrisModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" onclick="closeQrisModal()"></div>
    <div class="min-h-screen px-4 flex items-center justify-center">
        <div class="relative bg-stone-900 border border-stone-800 rounded-3xl p-6 max-w-sm w-full space-y-5 text-white text-center shadow-2xl">
            <h3 class="text-base font-bold pb-2 border-b border-stone-800">Scan QRIS Kasir</h3>
            <div id="qrisModalTotal" class="text-2xl font-mono font-black text-rose-500">Rp 0</div>
            
            <div class="p-2 bg-white rounded-2xl mx-auto inline-block border-2 border-stone-700 shadow-xl max-w-[260px]">
                <img src="{{ asset('images/qr/qris-stand.jpg') }}" alt="Standar QRIS Mie Gacoan" class="w-full h-auto object-contain rounded-xl">
            </div>
            <p class="text-xs text-stone-400">Silakan scan menggunakan BCA, GoPay, OVO, atau ShopeePay.</p>
            <button type="button" onclick="processPosOrder('qris')" class="w-full py-3 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs transition">
                Konfirmasi QRIS Sukses &amp; Cetak
            </button>
        </div>
    </div>
</div>

<!-- Modal: Thermal Receipt Simulator -->
<div id="thermalReceiptModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" onclick="closeThermalModal()"></div>
    <div class="min-h-screen px-4 flex items-center justify-center">
        <div class="relative bg-white text-stone-900 font-mono text-xs p-6 rounded-2xl max-w-xs w-full space-y-3 shadow-2xl border border-stone-300">
            <div class="text-center space-y-1">
                <img src="{{ asset('images/logo.png') }}" class="h-8 mx-auto object-contain">
                <h4 class="font-bold text-sm tracking-wider">MIE GACOAN FLAGSHIP</h4>
                <p class="text-[10px] text-stone-500">Jl. Raya Mulyosari No. 88, Surabaya</p>
                <p class="text-[10px] text-stone-500">Telp: (031) 5928819</p>
                <div class="border-b border-dashed border-stone-400 pt-2"></div>
            </div>

            <div class="space-y-1 text-[11px]">
                <div class="flex justify-between">
                    <span>No. Order:</span>
                    <strong id="receiptOrderCode">KM-POS-001</strong>
                </div>
                <div class="flex justify-between">
                    <span>Waktu:</span>
                    <span id="receiptTime">2026-09-21 12:00</span>
                </div>
                <div class="flex justify-between">
                    <span>Kasir:</span>
                    <span>{{ Auth::user()->name ?? 'Kasir' }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Tipe / Meja:</span>
                    <span id="receiptTypeMeja">Dine In / Meja A01</span>
                </div>
                <div class="border-b border-dashed border-stone-400 pt-1"></div>
            </div>

            <!-- Receipt Items -->
            <div id="receiptItemsContainer" class="space-y-1.5 text-[11px]"></div>

            <div class="border-b border-dashed border-stone-400 pt-1"></div>

            <div class="space-y-1 text-[11px]">
                <div class="flex justify-between">
                    <span>Subtotal:</span>
                    <span id="receiptSubtotal">Rp 0</span>
                </div>
                <div class="flex justify-between">
                    <span>Diskon:</span>
                    <span id="receiptDiscount">Rp 0</span>
                </div>
                <div class="flex justify-between">
                    <span>PB1 (10%):</span>
                    <span id="receiptTax">Rp 0</span>
                </div>
                <div class="flex justify-between font-bold text-xs pt-1 border-t border-stone-300">
                    <span>TOTAL:</span>
                    <span id="receiptTotal">Rp 0</span>
                </div>
                <div class="flex justify-between text-stone-600">
                    <span>Bayar:</span>
                    <span id="receiptPayment">Rp 0 (Cash)</span>
                </div>
            </div>

            <div class="text-center pt-2 pb-1 border-t border-dashed border-stone-400">
                <img src="{{ asset('images/qr/order-pickup-qr.jpg') }}" alt="QR Struk Pesanan" class="w-16 h-16 mx-auto object-contain">
                <p class="text-[9px] text-stone-500 font-mono tracking-wider mt-0.5">SCAN UNTUK CEK STATUS</p>
            </div>

            <div class="text-center pt-1 border-t border-dashed border-stone-400 space-y-1">
                <p class="text-[10px] font-bold">TERIMA KASIH ATAS KUNJUNGANNYA</p>
                <p class="text-[9px] text-stone-400">Simpan struk ini sebagai bukti pembayaran yang sah.</p>
            </div>

            <div class="pt-3 flex gap-2">
                <button type="button" onclick="window.print()" class="flex-1 py-2 bg-stone-900 text-white rounded-lg font-bold text-xs">
                    Print Thermal
                </button>
                <button type="button" onclick="closeThermalModal()" class="px-4 py-2 bg-stone-200 text-stone-800 rounded-lg font-bold text-xs">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let posTicketItems = [];
    let posOrderType = 'dine_in';
    let posDiscount = 0;
    let isSimulatedOffline = false;

    function filterPosCategory(cat) {
        document.querySelectorAll('.pos-cat-btn').forEach(btn => {
            if (btn.getAttribute('data-cat') === cat) {
                btn.className = 'pos-cat-btn px-4 py-2 rounded-xl text-xs font-bold bg-rose-600 text-white transition';
            } else {
                btn.className = 'pos-cat-btn px-4 py-2 rounded-xl text-xs font-bold bg-stone-800 text-stone-300 hover:bg-stone-700 transition';
            }
        });

        document.querySelectorAll('.pos-card').forEach(card => {
            if (cat === 'all' || card.getAttribute('data-category') === cat) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }

    function searchPosProducts() {
        const query = document.getElementById('posSearch').value.toLowerCase().trim();
        document.querySelectorAll('.pos-card').forEach(card => {
            const name = card.getAttribute('data-name');
            if (name.includes(query)) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }

    function toggleSimulatedOffline() {
        isSimulatedOffline = !isSimulatedOffline;
        const btn = document.getElementById('btnSimOffline');
        const pill = document.getElementById('networkStatusPill');
        const label = document.getElementById('networkStatusLabel');
        if (isSimulatedOffline) {
            btn.textContent = 'Mode: Offline (Simulasi)';
            btn.className = 'px-3 py-1.5 rounded-xl bg-amber-600 text-white text-xs font-bold border border-amber-500';
            pill.className = 'flex items-center px-2.5 py-1 rounded-full bg-amber-900/40 border border-amber-700/60 text-amber-300 font-medium text-[11px]';
            label.textContent = 'Mode POS Offline';
        } else {
            btn.textContent = 'Mode: Online';
            btn.className = 'px-3 py-1.5 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-300 text-xs font-semibold border border-stone-700';
            pill.className = 'flex items-center px-2.5 py-1 rounded-full bg-stone-800 border border-stone-700 text-stone-300 font-medium text-[11px]';
            label.textContent = 'Online Terhubung';
        }
    }

    function setPosOrderType(type) {
        posOrderType = type;
        const btnDine = document.getElementById('btnDineIn');
        const btnTake = document.getElementById('btnTakeaway');
        if (type === 'dine_in') {
            btnDine.className = 'py-2 px-3 rounded-xl font-bold bg-rose-600 text-white border border-rose-500 transition';
            btnTake.className = 'py-2 px-3 rounded-xl font-bold bg-stone-800 text-stone-400 border border-stone-700 hover:bg-stone-700 transition';
        } else {
            btnTake.className = 'py-2 px-3 rounded-xl font-bold bg-rose-600 text-white border border-rose-500 transition';
            btnDine.className = 'py-2 px-3 rounded-xl font-bold bg-stone-800 text-stone-400 border border-stone-700 hover:bg-stone-700 transition';
        }
    }

    function addPosItem(product) {
        const existing = posTicketItems.find(i => i.id === product.id && i.spicy_level === (product.has_spicy_level ? 1 : null));
        if (existing) {
            existing.quantity += 1;
        } else {
            posTicketItems.push({
                id: product.id,
                code: product.code,
                name: product.name,
                price: parseInt(product.price, 10),
                quantity: 1,
                spicy_level: product.has_spicy_level ? 1 : null
            });
        }
        renderPosTicket();
    }

    function updatePosQty(idx, delta) {
        if (posTicketItems[idx]) {
            posTicketItems[idx].quantity += delta;
            if (posTicketItems[idx].quantity <= 0) {
                posTicketItems.splice(idx, 1);
            }
            renderPosTicket();
        }
    }

    function setPosDiscount(val) {
        posDiscount = val;
        renderPosTicket();
    }

    function clearPosTicket() {
        posTicketItems = [];
        posDiscount = 0;
        renderPosTicket();
    }

    function renderPosTicket() {
        const emptyEl = document.getElementById('posTicketEmpty');
        const listEl = document.getElementById('posTicketItemsList');

        if (posTicketItems.length === 0) {
            emptyEl.classList.remove('hidden');
            listEl.innerHTML = '';
        } else {
            emptyEl.classList.add('hidden');
            let html = '';
            posTicketItems.forEach((item, idx) => {
                const spicyBadge = item.spicy_level !== null ? `<span class="text-[9px] px-1 py-0.2 bg-red-950 text-red-400 border border-red-800 font-bold rounded">Lv. ${item.spicy_level}</span>` : '';
                html += `
                    <div class="p-2.5 rounded-xl bg-stone-900 border border-stone-800 flex items-center justify-between text-xs">
                        <div class="flex-1 min-w-0 pr-2">
                            <h5 class="font-bold text-white truncate">${item.name}</h5>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="text-amber-400 font-mono">Rp ${(item.price).toLocaleString('id-ID')}</span>
                                ${spicyBadge}
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="flex items-center rounded-lg bg-stone-800 border border-stone-700 overflow-hidden font-mono text-xs">
                                <button type="button" onclick="updatePosQty(${idx}, -1)" class="px-2 py-1 text-stone-400 hover:text-white">-</button>
                                <span class="px-2 py-1 font-bold text-white">${item.quantity}</span>
                                <button type="button" onclick="updatePosQty(${idx}, 1)" class="px-2 py-1 text-stone-400 hover:text-white">+</button>
                            </div>
                            <span class="font-mono font-bold text-white w-20 text-right">
                                Rp ${(item.price * item.quantity).toLocaleString('id-ID')}
                            </span>
                        </div>
                    </div>
                `;
            });
            listEl.innerHTML = html;
        }

        const subtotal = posTicketItems.reduce((acc, i) => acc + (i.price * i.quantity), 0);
        const discountRow = document.getElementById('posDiscountRow');
        const discountText = document.getElementById('posDiscountText');
        if (posDiscount > 0) {
            discountRow.classList.remove('hidden');
            discountText.textContent = '-Rp ' + posDiscount.toLocaleString('id-ID');
        } else {
            discountRow.classList.add('hidden');
        }

        const tax = Math.round(Math.max(0, subtotal - posDiscount) * 0.10);
        const total = Math.max(0, subtotal - posDiscount + tax);

        document.getElementById('posSubtotalText').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        document.getElementById('posTaxText').textContent = 'Rp ' + tax.toLocaleString('id-ID');
        document.getElementById('posTotalText').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    function getTicketCalculations() {
        const subtotal = posTicketItems.reduce((acc, i) => acc + (i.price * i.quantity), 0);
        const tax = Math.round(Math.max(0, subtotal - posDiscount) * 0.10);
        const total = Math.max(0, subtotal - posDiscount + tax);
        return { subtotal, discount: posDiscount, tax, total };
    }

    function openCashPaymentModal() {
        if (posTicketItems.length === 0) {
            alert('Pilih item menu terlebih dahulu.');
            return;
        }
        const calc = getTicketCalculations();
        document.getElementById('cashModalTotal').textContent = 'Rp ' + calc.total.toLocaleString('id-ID');
        document.getElementById('cashReceivedInput').value = calc.total;
        calculateChange();
        document.getElementById('cashModal').classList.remove('hidden');
    }

    function closeCashModal() {
        document.getElementById('cashModal').classList.add('hidden');
    }

    function setCashReceived(val) {
        const calc = getTicketCalculations();
        if (val === 'exact') {
            document.getElementById('cashReceivedInput').value = calc.total;
        } else {
            document.getElementById('cashReceivedInput').value = val;
        }
        calculateChange();
    }

    function calculateChange() {
        const calc = getTicketCalculations();
        const received = parseInt(document.getElementById('cashReceivedInput').value, 10) || 0;
        const change = Math.max(0, received - calc.total);
        document.getElementById('cashChangeText').textContent = 'Rp ' + change.toLocaleString('id-ID');
    }

    function openQrisPaymentModal() {
        if (posTicketItems.length === 0) {
            alert('Pilih item menu terlebih dahulu.');
            return;
        }
        const calc = getTicketCalculations();
        document.getElementById('qrisModalTotal').textContent = 'Rp ' + calc.total.toLocaleString('id-ID');
        document.getElementById('qrisModal').classList.remove('hidden');
    }

    function closeQrisModal() {
        document.getElementById('qrisModal').classList.add('hidden');
    }

    function closeThermalModal() {
        document.getElementById('thermalReceiptModal').classList.add('hidden');
    }

    async function processPosOrder(paymentMethod) {
        const calc = getTicketCalculations();
        const customerName = document.getElementById('posCustomerName').value || 'Pelanggan Kasir';
        const tableNumber = document.getElementById('posTableNumber').value || null;
        const orderCode = 'POS-' + new Date().toISOString().slice(2,10).replace(/-/g,'') + '-' + Math.floor(100 + Math.random() * 900);

        const orderData = {
            order_code: orderCode,
            order_type: posOrderType,
            customer_name: customerName,
            table_number: tableNumber,
            payment_method: paymentMethod,
            items: posTicketItems,
            subtotal: calc.subtotal,
            discount: calc.discount,
            tax: calc.tax,
            total: calc.total,
            notes: 'Kasir POS'
        };

        closeCashModal();
        closeQrisModal();

        // Check if online or offline
        if (navigator.onLine && !isSimulatedOffline) {
            try {
                const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const res = await fetch('/pos/orders', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        ...orderData,
                        items: JSON.stringify(posTicketItems)
                    })
                });
                const resData = await res.json();
                if (resData.success) {
                    showThermalReceipt(orderData);
                    clearPosTicket();
                }
            } catch (err) {
                // Fallback to offline save
                await OfflineDB.saveOrder(orderData);
                showThermalReceipt(orderData);
                clearPosTicket();
            }
        } else {
            // Save directly to IndexedDB Offline DB
            await OfflineDB.saveOrder(orderData);
            showThermalReceipt(orderData);
            clearPosTicket();
        }
    }

    function showThermalReceipt(order) {
        document.getElementById('receiptOrderCode').textContent = order.order_code;
        document.getElementById('receiptTime').textContent = new Date().toLocaleString('id-ID');
        document.getElementById('receiptTypeMeja').textContent = (order.order_type === 'dine_in' ? 'Dine In' : 'Takeaway') + (order.table_number ? ' / Meja ' + order.table_number : '');
        
        let itemsHtml = '';
        order.items.forEach(i => {
            itemsHtml += `
                <div class="flex justify-between">
                    <span>${i.quantity}x ${i.name}</span>
                    <span>Rp ${(i.price * i.quantity).toLocaleString('id-ID')}</span>
                </div>
            `;
        });
        document.getElementById('receiptItemsContainer').innerHTML = itemsHtml;
        document.getElementById('receiptSubtotal').textContent = 'Rp ' + order.subtotal.toLocaleString('id-ID');
        document.getElementById('receiptDiscount').textContent = '-Rp ' + order.discount.toLocaleString('id-ID');
        document.getElementById('receiptTax').textContent = 'Rp ' + order.tax.toLocaleString('id-ID');
        document.getElementById('receiptTotal').textContent = 'Rp ' + order.total.toLocaleString('id-ID');
        document.getElementById('receiptPayment').textContent = 'Rp ' + order.total.toLocaleString('id-ID') + ' (' + order.payment_method.toUpperCase() + ')';

        document.getElementById('thermalReceiptModal').classList.remove('hidden');
    }
</script>
@endpush
@endsection
