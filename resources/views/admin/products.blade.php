@extends('layouts.admin')

@section('title', 'Manajemen Menu & Harga')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-base font-bold text-stone-900">Daftar Menu Restoran</h3>
            <p class="text-xs text-stone-500">Kelola stok ketersediaan, harga, dan varian hidangan.</p>
        </div>
        <button type="button" onclick="document.getElementById('addProductModal').classList.remove('hidden')" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-sm transition">
            + Tambah Menu Baru
        </button>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-stone-600">
                <thead class="bg-stone-50 text-[11px] font-bold uppercase tracking-wider text-stone-400 border-b border-stone-100">
                    <tr>
                        <th class="p-4 pl-6">Foto & Nama</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Harga Menu</th>
                        <th class="p-4">Level Pedas</th>
                        <th class="p-4">Status Ketersediaan</th>
                        <th class="p-4 pr-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach($products as $p)
                    <tr class="hover:bg-stone-50/50 transition">
                        <td class="p-4 pl-6">
                            <div class="flex items-center gap-3">
                                <img src="{{ $p->image }}" alt="{{ $p->name }}" class="w-12 h-12 object-cover rounded-xl bg-stone-100 flex-shrink-0">
                                <div>
                                    <div class="font-bold text-stone-900">{{ $p->name }}</div>
                                    <div class="text-[10px] text-stone-400 font-mono">{{ $p->code }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-stone-100 text-stone-700 uppercase">
                                {{ $p->category }}
                            </span>
                        </td>
                        <td class="p-4 font-mono font-bold text-stone-900">
                            Rp {{ number_format($p->price, 0, ',', '.') }}
                        </td>
                        <td class="p-4">
                            @if($p->has_spicy_level)
                                <span class="text-rose-600 font-semibold">Level 0-{{ $p->max_spicy_level }}</span>
                            @else
                                <span class="text-stone-400">Non-pedas</span>
                            @endif
                        </td>
                        <td class="p-4">
                            @if($p->is_available)
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Tersedia</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-800">Habis / Kosong</span>
                            @endif
                        </td>
                        <td class="p-4 pr-6 text-right">
                            <form method="POST" action="{{ route('admin.products.toggle', $p->id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-3 py-1.5 rounded-lg border text-[11px] font-semibold transition {{ $p->is_available ? 'border-red-200 text-red-600 hover:bg-red-50' : 'border-emerald-200 text-emerald-600 hover:bg-emerald-50' }}">
                                    {{ $p->is_available ? 'Tandai Habis' : 'Aktifkan Kembali' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="document.getElementById('addProductModal').classList.add('hidden')"></div>
    <div class="min-h-screen px-4 flex items-center justify-center">
        <div class="relative bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full space-y-5 shadow-2xl border border-stone-200">
            <h3 class="text-lg font-bold text-stone-900 pb-3 border-b border-stone-100 flex items-center justify-between">
                <span>Tambah Menu Baru</span>
                <button type="button" onclick="document.getElementById('addProductModal').classList.add('hidden')" class="text-stone-400 hover:text-stone-700">✕</button>
            </h3>

            <form method="POST" action="{{ route('admin.products.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-stone-700">Kode Menu</label>
                        <input type="text" name="code" placeholder="MIE-BARU" required class="w-full px-3 py-2 text-xs uppercase font-mono rounded-xl border border-stone-300">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-stone-700">Kategori</label>
                        <select name="category" required class="w-full px-3 py-2 text-xs rounded-xl border border-stone-300 bg-stone-50">
                            <option value="mie">Mie Pedas</option>
                            <option value="dimsum">Dimsum Renyah</option>
                            <option value="minuman">Minuman Segar</option>
                            <option value="paket">Paket Hemat</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-stone-700">Nama Menu</label>
                    <input type="text" name="name" placeholder="Contoh: Mie Gacoan Spesial" required class="w-full px-3 py-2 text-xs rounded-xl border border-stone-300">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-stone-700">Harga (Rp)</label>
                    <input type="number" name="price" placeholder="12000" required class="w-full px-3 py-2 text-xs rounded-xl border border-stone-300 font-mono">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-stone-700">URL Gambar Produk</label>
                    <input type="url" name="image" placeholder="https://images.unsplash.com/..." required class="w-full px-3 py-2 text-xs rounded-xl border border-stone-300">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-stone-700">Deskripsi Menu</label>
                    <textarea name="description" rows="2" placeholder="Jelaskan cita rasa hidangan..." required class="w-full px-3 py-2 text-xs rounded-xl border border-stone-300"></textarea>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" name="has_spicy_level" value="1" id="hasSpicyCheck" class="rounded text-rose-600 focus:ring-rose-500">
                    <label for="hasSpicyCheck" class="text-xs font-semibold text-stone-700">Memiliki Pengaturan Level Pedas (0 - 8)</label>
                </div>

                <div class="pt-3 border-t border-stone-100 flex gap-2">
                    <button type="button" onclick="document.getElementById('addProductModal').classList.add('hidden')" class="px-4 py-2.5 rounded-xl border border-stone-300 text-xs font-semibold text-stone-600">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-sm">Simpan Menu Baru</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
