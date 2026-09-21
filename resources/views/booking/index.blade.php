@extends('layouts.app')

@section('title', 'Reservasi Meja Restoran - Mie Gacoan')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header -->
        <div data-animate="fadeInDown" class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-6 border-b border-slate-200">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-slate-400 block font-heading mb-1">LAYANAN RESERVASI</span>
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 font-heading">Reservasi Meja &amp; Ruangan</h1>
                <p class="text-slate-600 text-xs sm:text-sm mt-1">Pesan tempat terlebih dahulu untuk kenyamanan bersantap bersama rekan dan keluarga.</p>
            </div>
            <div class="flex items-center gap-3 text-xs font-medium">
                <span class="inline-flex items-center px-3 py-1 bg-white border border-slate-200 rounded-md text-slate-700 font-semibold">
                    Meja Tersedia
                </span>
                <span class="inline-flex items-center px-3 py-1 bg-slate-100 border border-slate-200 rounded-md text-slate-400">
                    Meja Terisi
                </span>
            </div>
        </div>

        @if($errors->any())
        <div class="p-3.5 rounded-lg bg-red-50 border border-red-200 text-red-700 text-xs">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left: Interactive Table Floor Plan -->
            <div data-animate="fadeInLeft" class="lg:col-span-7 space-y-6">
                <div class="card-luxury bg-white p-6 sm:p-8 rounded-xl border border-slate-200 space-y-6">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <h3 class="text-sm font-bold text-slate-900 font-heading">Denah Meja Restoran</h3>
                        <span class="text-xs text-slate-400">Pilih nomor meja di bawah ini</span>
                    </div>

                    <!-- 1. Indoor AC -->
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                            <span>Area Indoor AC</span>
                            <span class="text-slate-400 font-normal">Kapasitas 2-6 Orang</span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                            @foreach($tables->where('room', 'Indoor AC') as $tbl)
                            <button type="button" 
                                    onclick="selectFloorTable('{{ $tbl->id }}', '{{ $tbl->table_number }}', 'Indoor AC')"
                                    class="p-3 rounded-lg border text-center transition cursor-pointer {{ $tbl->status === 'available' ? 'border-slate-200 hover:border-slate-900 bg-white' : 'border-slate-100 bg-slate-50 opacity-40 cursor-not-allowed' }}"
                                    {{ $tbl->status !== 'available' ? 'disabled' : '' }}>
                                <div class="text-xs font-bold text-slate-900 font-heading">Meja {{ $tbl->table_number }}</div>
                                <div class="text-[10px] text-slate-500 mt-0.5">{{ $tbl->capacity }} Kursi</div>
                                <div class="text-[10px] font-semibold mt-1 {{ $tbl->status === 'available' ? 'text-emerald-700' : 'text-slate-400' }}">
                                    {{ $tbl->status === 'available' ? 'Tersedia' : 'Terisi' }}
                                </div>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- 2. Outdoor -->
                    <div class="space-y-3 pt-4 border-t border-slate-100">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                            <span>Area Outdoor</span>
                            <span class="text-slate-400 font-normal">Kapasitas 4-6 Orang</span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                            @foreach($tables->where('room', 'Outdoor') as $tbl)
                            <button type="button" 
                                    onclick="selectFloorTable('{{ $tbl->id }}', '{{ $tbl->table_number }}', 'Outdoor')"
                                    class="p-3 rounded-lg border text-center transition cursor-pointer {{ $tbl->status === 'available' ? 'border-slate-200 hover:border-slate-900 bg-white' : 'border-slate-100 bg-slate-50 opacity-40 cursor-not-allowed' }}"
                                    {{ $tbl->status !== 'available' ? 'disabled' : '' }}>
                                <div class="text-xs font-bold text-slate-900 font-heading">Meja {{ $tbl->table_number }}</div>
                                <div class="text-[10px] text-slate-500 mt-0.5">{{ $tbl->capacity }} Kursi</div>
                                <div class="text-[10px] font-semibold mt-1 {{ $tbl->status === 'available' ? 'text-emerald-700' : 'text-slate-400' }}">
                                    {{ $tbl->status === 'available' ? 'Tersedia' : 'Terisi' }}
                                </div>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- 3. VIP Room -->
                    <div class="space-y-3 pt-4 border-t border-slate-100">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                            <span>Ruang VIP Privat</span>
                            <span class="text-slate-400 font-normal">Kapasitas 8-10 Orang</span>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($tables->where('room', 'VIP Room') as $tbl)
                            <button type="button" 
                                    onclick="selectFloorTable('{{ $tbl->id }}', '{{ $tbl->table_number }}', 'VIP Room')"
                                    class="p-3.5 rounded-lg border text-center transition cursor-pointer {{ $tbl->status === 'available' ? 'border-slate-300 hover:border-slate-900 bg-white' : 'border-slate-100 bg-slate-50 opacity-40 cursor-not-allowed' }}"
                                    {{ $tbl->status !== 'available' ? 'disabled' : '' }}>
                                <div class="text-xs font-bold text-slate-900 font-heading">Ruangan {{ $tbl->table_number }}</div>
                                <div class="text-[10px] text-slate-500 mt-0.5">{{ $tbl->capacity }} Kursi &bull; Privat</div>
                                <div class="text-[10px] font-semibold mt-1 text-slate-900">Tersedia</div>
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Existing User Bookings -->
                @if(Auth::check() && $userBookings->count() > 0)
                <div class="bg-white p-6 rounded-xl border border-slate-200 space-y-3">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider font-heading">Reservasi Aktif Anda</h3>
                    <div class="space-y-2">
                        @foreach($userBookings as $b)
                        <div class="p-3 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-between text-xs">
                            <div>
                                <span class="font-bold text-slate-900 tracking-wider">#{{ $b->booking_code }}</span>
                                <div class="font-semibold text-slate-800 mt-0.5">{{ $b->guests_count }} Orang &bull; {{ $b->room_preference }}</div>
                                <div class="text-slate-500 text-[11px]">{{ $b->booking_date }} pukul {{ $b->booking_time }} WIB</div>
                            </div>
                            <span class="px-2.5 py-0.5 bg-emerald-100 text-emerald-800 rounded text-[11px] font-semibold uppercase">
                                {{ $b->status }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Right: Reservation Form -->
            <div data-animate="fadeInRight" class="lg:col-span-5">
                <form method="POST" action="{{ route('booking.store') }}" class="card-luxury bg-white p-6 sm:p-8 rounded-xl border border-slate-200 space-y-4 sticky top-28">
                    @csrf
                    <h3 class="text-sm font-bold text-slate-900 pb-3 border-b border-slate-100 font-heading">
                        Formulir Reservasi
                    </h3>

                    <div id="selectedTableBox" class="hidden p-3 rounded-lg bg-slate-50 border border-slate-200 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-slate-800">Meja: <strong id="selectedTableLabel">-</strong></span>
                            <button type="button" onclick="clearSelectedTable()" class="text-rose-600 hover:underline">Ganti</button>
                        </div>
                    </div>
                    <input type="hidden" name="table_id" id="formTableId">

                    <div class="space-y-1">
                        <label for="branch_id" class="text-xs font-bold text-slate-700">Pilih Outlet</label>
                        <select name="branch_id" id="branch_id" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white focus:outline-none focus:border-slate-500">
                            @foreach($branches as $b)
                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label for="room_preference" class="text-xs font-bold text-slate-700">Pilihan Area</label>
                        <select name="room_preference" id="room_preference" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white focus:outline-none focus:border-slate-500">
                            <option value="Indoor AC">Indoor AC (Bebas Asap)</option>
                            <option value="Outdoor">Outdoor</option>
                            <option value="VIP Room">VIP Room (Privat)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label for="booking_date" class="text-xs font-bold text-slate-700">Tanggal</label>
                            <input type="date" name="booking_date" id="booking_date" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 focus:outline-none focus:border-slate-500">
                        </div>

                        <div class="space-y-1">
                            <label for="booking_time" class="text-xs font-bold text-slate-700">Jam Kedatangan</label>
                            <select name="booking_time" id="booking_time" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 focus:outline-none focus:border-slate-500 bg-white">
                                <option value="11:30">11:30 WIB</option>
                                <option value="13:00">13:00 WIB</option>
                                <option value="17:00">17:00 WIB</option>
                                <option value="18:30" selected>18:30 WIB</option>
                                <option value="19:30">19:30 WIB</option>
                                <option value="20:30">20:30 WIB</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="guests_count" class="text-xs font-bold text-slate-700">Jumlah Tamu (Orang)</label>
                        <input type="number" name="guests_count" id="guests_count" min="1" max="20" value="4" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:outline-none focus:border-slate-500">
                    </div>

                    <div class="space-y-3 pt-2 border-t border-slate-100">
                        <div class="space-y-1">
                            <label for="customer_name" class="text-xs font-bold text-slate-700">Nama Lengkap</label>
                            <input type="text" name="customer_name" id="customer_name" value="{{ Auth::check() ? Auth::user()->name : old('customer_name') }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:outline-none focus:border-slate-500">
                        </div>

                        <div class="space-y-1">
                            <label for="customer_phone" class="text-xs font-bold text-slate-700">Nomor Telepon / WhatsApp</label>
                            <input type="tel" name="customer_phone" id="customer_phone" value="{{ Auth::check() ? Auth::user()->phone : old('customer_phone') }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:outline-none focus:border-slate-500">
                        </div>

                        <div class="space-y-1">
                            <label for="notes" class="text-xs font-bold text-slate-700">Catatan Khusus (Opsional)</label>
                            <input type="text" name="notes" id="notes" placeholder="Contoh: Meja untuk perayaan ulang tahun." class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:outline-none focus:border-slate-500">
                        </div>
                    </div>

                    <button type="submit" class="btn-luxury btn-shimmer w-full py-3 px-4 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition text-center">
                        Konfirmasi Reservasi &nbsp;&rarr;
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function selectFloorTable(tableId, tableNumber, room) {
        document.getElementById('formTableId').value = tableId;
        document.getElementById('selectedTableLabel').textContent = `Meja ${tableNumber} (${room})`;
        document.getElementById('selectedTableBox').classList.remove('hidden');
        document.getElementById('room_preference').value = room;
    }

    function clearSelectedTable() {
        document.getElementById('formTableId').value = '';
        document.getElementById('selectedTableBox').classList.add('hidden');
    }
</script>
@endpush
@endsection
