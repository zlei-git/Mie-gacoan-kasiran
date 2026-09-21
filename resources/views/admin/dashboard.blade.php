@extends('layouts.admin')

@section('title', 'Dashboard Operasional Restoran')

@section('content')
<div class="space-y-8">
    
    <!-- Top KPI Metrics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Revenue Today -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 space-y-2">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                Pendapatan Hari Ini
            </div>
            <div class="text-2xl font-bold text-slate-900 font-mono">
                Rp {{ number_format($todayRevenue, 0, ',', '.') }}
            </div>
            <div class="text-[11px] text-slate-400">Total akumulasi: Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>

        <!-- Orders Today -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 space-y-2">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                Pesanan Masuk
            </div>
            <div class="text-2xl font-bold text-slate-900 font-mono">
                {{ $todayOrdersCount }} <span class="text-xs font-normal text-slate-400">Transaksi</span>
            </div>
            <div class="text-[11px] text-slate-400">Tercatat hari ini</div>
        </div>

        <!-- Kitchen Queue -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 space-y-2">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                Antrean di Dapur
            </div>
            <div class="text-2xl font-bold text-slate-900 font-mono">
                {{ $inKitchenOrdersCount }} <span class="text-xs font-normal text-slate-400">Antrean</span>
            </div>
            <div class="text-[11px] text-slate-400">Sedang disiapkan di dapur</div>
        </div>

        <!-- Table Occupancy -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 space-y-2">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                Okupansi Meja
            </div>
            <div class="text-2xl font-bold text-slate-900 font-mono">
                {{ $tableOccupancy }}%
            </div>
            <div class="text-[11px] text-slate-400">{{ $occupiedTables }} dari {{ $totalTables }} meja terisi</div>
        </div>
    </div>

    <!-- Recent Orders & Kitchen Queue Section -->
    <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-stone-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-stone-900">Pesanan Masuk Terbaru</h3>
                <p class="text-xs text-stone-500 mt-0.5">Monitoring live transaksi pelanggan & kasir</p>
            </div>
            <a href="{{ route('admin.orders') }}" class="text-xs font-bold text-rose-600 hover:underline">Lihat Semua Pesanan &rarr;</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-stone-600">
                <thead class="bg-stone-50 text-[11px] font-bold uppercase tracking-wider text-stone-400 border-b border-stone-100">
                    <tr>
                        <th class="p-4 pl-6">Kode Order</th>
                        <th class="p-4">Pelanggan / Tipe</th>
                        <th class="p-4">Menu Dipesan</th>
                        <th class="p-4">Total Biaya</th>
                        <th class="p-4">Status Transaksi</th>
                        <th class="p-4 pr-6 text-right">Aksi Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach($recentOrders as $order)
                    <tr class="hover:bg-stone-50/50 transition">
                        <td class="p-4 pl-6 font-mono font-bold text-stone-900">
                            {{ $order->order_code }}
                        </td>
                        <td class="p-4">
                            <div class="font-bold text-stone-900">{{ $order->customer_name }}</div>
                            <div class="text-[10px] text-stone-400 capitalize">{{ str_replace('_', ' ', $order->order_type) }} @if($order->table_number) • Meja {{ $order->table_number }} @endif</div>
                        </td>
                        <td class="p-4 max-w-xs truncate">
                            {{ collect($order->items)->pluck('name')->implode(', ') }}
                        </td>
                        <td class="p-4 font-mono font-bold text-stone-900">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </td>
                        <td class="p-4">
                            @if($order->status === 'completed')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Selesai</span>
                            @elseif($order->status === 'ready_pickup')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Siap Ambil</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">Di Dapur</span>
                            @endif
                        </td>
                        <td class="p-4 pr-6 text-right">
                            <form method="POST" action="{{ route('admin.orders.status', $order->id) }}" class="inline-flex items-center gap-1">
                                @csrf
                                @method('PATCH')
                                @if($order->status === 'in_kitchen')
                                    <input type="hidden" name="status" value="ready_pickup">
                                    <button type="submit" class="px-3 py-1 bg-amber-500 hover:bg-amber-600 text-white rounded-lg font-bold text-[10px] transition">
                                        Siap Saji
                                    </button>
                                @elseif($order->status === 'ready_pickup')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-[10px] transition">
                                        Selesaikan
                                    </button>
                                @else
                                    <span class="text-stone-400 text-[10px]">Telah Selesai</span>
                                @endif
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
