@extends('layouts.admin')

@section('title', 'Status Denah Meja Restoran')

@section('content')
<div class="space-y-6">
    <div>
        <h3 class="text-base font-bold text-stone-900">Manajemen Okupansi Meja</h3>
        <p class="text-xs text-stone-500">Pantau dan ubah status meja langsung dari sistem manajemen.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($tables as $table)
        <div class="bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-lg font-black text-stone-900">Meja {{ $table->table_number }}</span>
                @if($table->status === 'available')
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Tersedia</span>
                @elseif($table->status === 'occupied')
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">Terisi Pelanggan</span>
                @else
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Direservasi</span>
                @endif
            </div>

            <div class="text-xs text-stone-500 space-y-1">
                <div>Ruangan: <strong class="text-stone-800">{{ $table->room }}</strong></div>
                <div>Kapasitas: <strong class="text-stone-800">{{ $table->capacity }} Orang</strong></div>
            </div>

            <form method="POST" action="{{ route('admin.tables.status', $table->id) }}" class="pt-3 border-t border-stone-100 flex gap-2">
                @csrf
                @method('PATCH')
                <select name="status" class="flex-1 px-2.5 py-1.5 rounded-xl border border-stone-300 text-xs bg-stone-50 focus:outline-none">
                    <option value="available" {{ $table->status === 'available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="occupied" {{ $table->status === 'occupied' ? 'selected' : '' }}>Terisi</option>
                    <option value="reserved" {{ $table->status === 'reserved' ? 'selected' : '' }}>Reservasi</option>
                </select>
                <button type="submit" class="px-3 py-1.5 rounded-xl bg-stone-900 text-white text-xs font-bold hover:bg-stone-800 transition">
                    Ubah
                </button>
            </form>
        </div>
        @endforeach
    </div>
</div>
@endsection
