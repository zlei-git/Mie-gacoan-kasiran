@extends('layouts.admin')

@section('title', 'Manajemen Reservasi Meja Pelanggan')

@section('content')
<div class="space-y-6">
    <div>
        <h3 class="text-base font-bold text-stone-900">Daftar Pengajuan Reservasi</h3>
        <p class="text-xs text-stone-500">Konfirmasi reservasi meja dan tentukan status kedatangan tamu.</p>
    </div>

    <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-stone-600">
                <thead class="bg-stone-50 text-[11px] font-bold uppercase tracking-wider text-stone-400 border-b border-stone-100">
                    <tr>
                        <th class="p-4 pl-6">Kode Booking</th>
                        <th class="p-4">Nama Pelanggan</th>
                        <th class="p-4">Jadwal Kedatangan</th>
                        <th class="p-4">Jumlah Tamu & Ruangan</th>
                        <th class="p-4">Status Booking</th>
                        <th class="p-4 pr-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach($bookings as $b)
                    <tr class="hover:bg-stone-50/50 transition">
                        <td class="p-4 pl-6 font-mono font-bold text-stone-900">
                            #{{ $b->booking_code }}
                        </td>
                        <td class="p-4">
                            <div class="font-bold text-stone-900">{{ $b->customer_name }}</div>
                            <div class="text-[10px] text-stone-400">{{ $b->customer_phone }}</div>
                        </td>
                        <td class="p-4">
                            <div class="font-semibold text-stone-800">{{ $b->booking_date }}</div>
                            <div class="text-[10px] text-stone-400">{{ $b->booking_time }} WIB</div>
                        </td>
                        <td class="p-4">
                            <span class="font-bold text-stone-900">{{ $b->guests_count }} Orang</span>
                            <div class="text-[10px] text-stone-400">{{ $b->room_preference }} @if($b->table) • Meja {{ $b->table->table_number }} @endif</div>
                        </td>
                        <td class="p-4">
                            @if($b->status === 'confirmed')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Dikonfirmasi</span>
                            @elseif($b->status === 'seated')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-purple-100 text-purple-800">Sudah Hadir</span>
                            @elseif($b->status === 'cancelled')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-800">Dibatalkan</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Menunggu</span>
                            @endif
                        </td>
                        <td class="p-4 pr-6 text-right">
                            <form method="POST" action="{{ route('admin.bookings.status', $b->id) }}" class="inline-flex items-center gap-1.5">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="px-2 py-1 rounded-lg border border-stone-300 text-[11px] bg-stone-50">
                                    <option value="confirmed" {{ $b->status === 'confirmed' ? 'selected' : '' }}>Konfirmasi</option>
                                    <option value="seated" {{ $b->status === 'seated' ? 'selected' : '' }}>Hadir</option>
                                    <option value="cancelled" {{ $b->status === 'cancelled' ? 'selected' : '' }}>Batalkan</option>
                                </select>
                                <button type="submit" class="px-2.5 py-1 rounded-lg bg-stone-900 text-white font-bold text-[11px]">Update</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="pt-2">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
