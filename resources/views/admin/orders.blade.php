@extends('layouts.admin')

@section('title', 'Pesanan & Antrean Dapur (KDS)')

@section('content')
<div class="space-y-6">
    <!-- Header & Status Filter Pills -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-base font-bold text-stone-900">Daftar Antrean & Transaksi</h3>
            <p class="text-xs text-stone-500">Ubah status pesanan agar tersinkronisasi live dengan layar pelanggan.</p>
        </div>

        <div class="flex items-center gap-1.5 overflow-x-auto text-xs font-semibold">
            <a href="{{ route('admin.orders') }}" class="px-3 py-1.5 rounded-xl border {{ empty($status) ? 'bg-stone-900 text-white border-stone-900' : 'bg-white text-stone-600 border-stone-200' }}">Semua</a>
            <a href="{{ route('admin.orders', ['status' => 'in_kitchen']) }}" class="px-3 py-1.5 rounded-xl border {{ $status === 'in_kitchen' ? 'bg-rose-600 text-white border-rose-600' : 'bg-white text-stone-600 border-stone-200' }}">Di Dapur</a>
            <a href="{{ route('admin.orders', ['status' => 'ready_pickup']) }}" class="px-3 py-1.5 rounded-xl border {{ $status === 'ready_pickup' ? 'bg-amber-500 text-white border-amber-500' : 'bg-white text-stone-600 border-stone-200' }}">Siap Ambil</a>
            <a href="{{ route('admin.orders', ['status' => 'completed']) }}" class="px-3 py-1.5 rounded-xl border {{ $status === 'completed' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white text-stone-600 border-stone-200' }}">Selesai</a>
        </div>
    </div>

    <!-- Orders Grid / Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($orders as $order)
        <div class="bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm flex flex-col justify-between space-y-4">
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="font-mono font-bold text-stone-900 text-sm">#{{ $order->order_code }}</span>
                    @if($order->status === 'completed')
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Selesai</span>
                    @elseif($order->status === 'ready_pickup')
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Siap Saji</span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">Di Dapur</span>
                    @endif
                </div>

                <div class="text-xs">
                    <div class="font-bold text-stone-800">{{ $order->customer_name }} • {{ $order->customer_phone }}</div>
                    <div class="text-stone-400 text-[11px] capitalize mt-0.5">
                        {{ str_replace('_', ' ', $order->order_type) }} 
                        @if($order->table_number) • Meja {{ $order->table_number }} @endif
                    </div>
                </div>

                <!-- Items -->
                <div class="p-3 rounded-2xl bg-stone-50 border border-stone-100 space-y-1.5 text-xs">
                    @foreach($order->items as $item)
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-stone-800">
                            {{ $item['quantity'] ?? 1 }}x {{ $item['name'] }}
                            @if(isset($item['spicy_level']) && $item['spicy_level'] !== null)
                                <span class="text-[10px] text-red-600 font-bold">(Lv.{{ $item['spicy_level'] }})</span>
                            @endif
                        </span>
                        <span class="font-mono text-stone-500">Rp {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>

                @if($order->notes)
                <div class="text-[11px] text-amber-700 bg-amber-50 p-2 rounded-xl border border-amber-200/60">
                    <strong>Catatan:</strong> {{ $order->notes }}
                </div>
                @endif
            </div>

            <!-- Action Form -->
            <div class="pt-3 border-t border-stone-100 flex items-center justify-between gap-2">
                <div class="text-xs">
                    <span class="text-[10px] text-stone-400 block">Total</span>
                    <strong class="text-stone-900 font-mono text-sm">Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                </div>

                <form method="POST" action="{{ route('admin.orders.status', $order->id) }}" class="flex gap-1.5">
                    @csrf
                    @method('PATCH')
                    @if($order->status === 'in_kitchen')
                        <input type="hidden" name="status" value="ready_pickup">
                        <button type="submit" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-bold text-xs shadow-sm transition">
                            Tandai Siap Saji &rarr;
                        </button>
                    @elseif($order->status === 'ready_pickup')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs shadow-sm transition">
                            Selesaikan Order &rarr;
                        </button>
                    @else
                        <span class="text-xs text-stone-400 py-1.5">Pesanan Selesai</span>
                    @endif
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-20 bg-white rounded-3xl border border-stone-200">
            <p class="text-stone-500 text-xs">Tidak ada pesanan dengan status ini.</p>
        </div>
        @endforelse
    </div>

    <div class="pt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
