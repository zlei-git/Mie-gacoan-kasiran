@extends('layouts.admin')

@section('title', 'Manajemen Promo & Voucher Diskon')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-base font-bold text-stone-900">Daftar Kode Promo Aktif</h3>
            <p class="text-xs text-stone-500">Buat voucher diskon persentase atau nominal tetap untuk menarik pelanggan.</p>
        </div>
        <button type="button" onclick="document.getElementById('addPromoModal').classList.remove('hidden')" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-sm transition">
            + Tambah Voucher Baru
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($promos as $promo)
        <div class="bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <span class="font-mono text-sm font-black text-rose-600 bg-rose-50 border border-rose-200 px-3 py-1 rounded-xl">
                    {{ $promo->code }}
                </span>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Aktif</span>
            </div>

            <div class="space-y-1">
                <h4 class="text-sm font-bold text-stone-900">{{ $promo->title }}</h4>
                <div class="text-xs text-stone-500">
                    Diskon: <strong class="text-stone-800">{{ $promo->discount_type === 'percent' ? $promo->discount_value . '%' : 'Rp ' . number_format($promo->discount_value, 0, ',', '.') }}</strong>
                </div>
                <div class="text-xs text-stone-500">
                    Min. Pembelian: <span class="font-mono">Rp {{ number_format($promo->min_order, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Add Promo Modal -->
<div id="addPromoModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="document.getElementById('addPromoModal').classList.add('hidden')"></div>
    <div class="min-h-screen px-4 flex items-center justify-center">
        <div class="relative bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full space-y-5 shadow-2xl border border-stone-200">
            <h3 class="text-lg font-bold text-stone-900 pb-3 border-b border-stone-100 flex items-center justify-between">
                <span>Buat Voucher Promo Baru</span>
                <button type="button" onclick="document.getElementById('addPromoModal').classList.add('hidden')" class="text-stone-400 hover:text-stone-700">✕</button>
            </h3>

            <form method="POST" action="{{ route('admin.promos.store') }}" class="space-y-4">
                @csrf
                <div class="space-y-1">
                    <label class="text-xs font-bold text-stone-700">Kode Voucher (Huruf Besar)</label>
                    <input type="text" name="code" placeholder="GACOANSERU" required class="w-full px-3.5 py-2 text-xs uppercase font-mono font-bold rounded-xl border border-stone-300">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-stone-700">Judul Penawaran</label>
                    <input type="text" name="title" placeholder="Diskon Akhir Pekan 15%" required class="w-full px-3.5 py-2 text-xs rounded-xl border border-stone-300">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-stone-700">Tipe Diskon</label>
                        <select name="discount_type" required class="w-full px-3 py-2 text-xs rounded-xl border border-stone-300 bg-stone-50">
                            <option value="percent">Persentase (%)</option>
                            <option value="fixed">Nominal Tetap (Rp)</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-stone-700">Nilai Diskon</label>
                        <input type="number" name="discount_value" placeholder="15 atau 5000" required class="w-full px-3 py-2 text-xs rounded-xl border border-stone-300 font-mono">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-stone-700">Minimal Pembelian (Rp)</label>
                    <input type="number" name="min_order" value="25000" required class="w-full px-3 py-2 text-xs rounded-xl border border-stone-300 font-mono">
                </div>

                <div class="pt-3 border-t border-stone-100 flex gap-2">
                    <button type="button" onclick="document.getElementById('addPromoModal').classList.add('hidden')" class="px-4 py-2.5 rounded-xl border border-stone-300 text-xs font-semibold text-stone-600">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-sm">Simpan Kode Promo</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
