<div>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <span>Ringkasan Laporan Penjualan</span>
            <a href="{{ route('admin.reports.export') }}" class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-2 px-4 rounded text-sm transition">
                Export to CSV / Excel
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 mt-4">
        <div class="bg-gradient-to-br from-orange-400 to-orange-600 text-white p-6 rounded-2xl shadow-xl shadow-orange-500/20 border border-orange-500/50 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/20 rounded-full blur-xl group-hover:scale-150 transition-transform duration-700"></div>
            <h3 class="text-orange-100 text-xs font-bold uppercase tracking-wider relative z-10">Total Pendapatan Sukses</h3>
            <div class="mt-2 text-3xl font-black relative z-10">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 relative overflow-hidden">
            <h3 class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Order Sukses</h3>
            <div class="mt-2 text-3xl font-black text-slate-800">{{ number_format($totalOrders) }} <span class="text-sm font-medium text-slate-500">Transaksi</span></div>
        </div>
    </div>

    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.05)] border border-slate-100">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-xl text-slate-800">10 Transaksi Terbaru</h3>
                <p class="text-sm text-slate-500 mt-1">Daftar transaksi yang baru saja diselesaikan.</p>
            </div>
            <div class="p-2 bg-orange-50 rounded-lg">
                <svg class="w-6 h-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>
        <div class="overflow-x-auto rounded-xl border border-slate-100">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="p-3 text-sm text-gray-600">ID Order</th>
                        <th class="p-3 text-sm text-gray-600">Tanggal</th>
                        <th class="p-3 text-sm text-gray-600">Pelanggan</th>
                        <th class="p-3 text-sm text-gray-600">Kasir</th>
                        <th class="p-3 text-sm text-gray-600">Subtotal</th>
                        <th class="p-3 text-sm text-gray-600">Pajak</th>
                        <th class="p-3 text-sm text-gray-600">Total</th>
                        <th class="p-3 text-sm text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr wire:key="order-{{ $order->id }}" class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                            <td class="p-4">
                                <button wire:click="showOrderDetails({{ $order->id }})" class="font-bold text-orange-600 hover:text-orange-700 hover:underline transition bg-orange-50 px-2 py-0.5 rounded">
                                    {{ $order->order_number }}
                                </button>
                            </td>
                            <td class="p-3 text-gray-600 text-sm">{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td class="p-3">{{ $order->customer_name ?: '-' }}</td>
                            <td class="p-3">{{ $order->user->name ?? 'Unknown' }}</td>
                            <td class="p-3">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                            <td class="p-3 text-red-500">Rp {{ number_format($order->tax, 0, ',', '.') }}</td>
                            <td class="p-3 font-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-xs font-bold 
                                    {{ $order->status === 'paid' ? 'bg-green-100 text-green-700' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ strtoupper($order->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center p-6 text-gray-500">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Detail Pesanan -->
    @if($showModal && $selectedOrder)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm animate-fade-in">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col transform scale-100 transition-all">
            <!-- Header Modal -->
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-white relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gradient-to-b from-orange-400 to-orange-600"></div>
                <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2 pl-2">
                    <svg class="w-6 h-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Detail: <span class="text-orange-600">{{ $selectedOrder->order_number }}</span>
                </h3>
                <button wire:click="closeModal" class="text-slate-400 hover:text-red-500 p-2 rounded-full hover:bg-red-50 transition-colors bg-slate-50 border border-slate-100 shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <div class="p-6 overflow-y-auto flex-1 bg-slate-50/50">
                <!-- Info Grid -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6 bg-white border border-slate-100 shadow-sm p-5 rounded-2xl text-sm">
                    <div>
                        <p class="text-slate-400 font-bold mb-1 text-[10px] uppercase tracking-widest">Tanggal</p>
                        <p class="font-black text-slate-700">{{ $selectedOrder->created_at->format('d M Y') }}</p>
                        <p class="text-xs text-orange-500 font-bold">{{ $selectedOrder->created_at->format('H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 font-bold mb-1 text-[10px] uppercase tracking-widest">Kasir</p>
                        <p class="font-bold text-slate-700">{{ $selectedOrder->user->name ?? 'Unknown' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 font-bold mb-1 text-[10px] uppercase tracking-widest">Pelanggan</p>
                        <p class="font-bold text-slate-700">{{ $selectedOrder->customer_name ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 font-bold mb-1 text-[10px] uppercase tracking-widest">Status</p>
                        <span class="px-2 py-1 rounded text-xs font-bold {{ $selectedOrder->status === 'paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                            {{ strtoupper($selectedOrder->status) }}
                        </span>
                    </div>
                </div>

                <table class="w-full text-left border-collapse mb-6">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wider">
                            <th class="py-3 px-3 border-b font-medium rounded-tl-lg">Menu</th>
                            <th class="py-3 px-3 border-b text-center font-medium">Qty</th>
                            <th class="py-3 px-3 border-b text-right font-medium">Harga</th>
                            <th class="py-3 px-3 border-b text-right font-medium rounded-tr-lg">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($selectedOrder->items as $item)
                        <tr class="border-b border-gray-100 text-sm hover:bg-gray-50">
                            <td class="py-3 px-3 font-semibold text-gray-800">{{ $item->menu->name ?? 'Menu Dihapus' }}</td>
                            <td class="py-3 px-3 text-center text-gray-600 font-medium">{{ $item->quantity }}</td>
                            <td class="py-3 px-3 text-right text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="py-3 px-3 text-right font-bold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">Detail item tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="w-full max-w-xs ml-auto space-y-2 text-sm bg-gray-50 p-4 rounded-lg border border-gray-100 shadow-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500 font-medium">Subtotal</span>
                        <span class="font-bold text-gray-800">Rp {{ number_format($selectedOrder->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 font-medium">PPN (11%)</span>
                        <span class="font-bold text-red-500">Rp {{ number_format($selectedOrder->tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between pt-3 border-t border-gray-200 mt-2">
                        <span class="font-black text-gray-900 uppercase">Total Bayar</span>
                        <span class="font-black text-indigo-600 text-lg">Rp {{ number_format($selectedOrder->total, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                @if($selectedOrder->notes)
                <div class="mt-6 text-sm bg-yellow-50 p-4 border border-yellow-200 rounded-lg text-yellow-800 flex gap-3">
                    <svg class="w-5 h-5 shrink-0 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <div>
                        <strong class="block mb-1">Catatan Tambahan:</strong>
                        <p>{{ $selectedOrder->notes }}</p>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Modal Footer -->
            <div class="px-6 py-5 border-t border-slate-100 bg-white text-right">
                <button wire:click="closeModal" class="bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 active:scale-95 text-white font-bold py-2.5 px-8 rounded-xl shadow-lg shadow-orange-500/30 transition-all">
                    Tutup Detail
                </button>
            </div>
        </div>
    </div>
    <style>
        .animate-fade-in { animation: fadeIn 0.3s ease-out; }
        @keyframes fadeIn { 0% { opacity: 0; transform: scale(0.95) } 100% { opacity: 1; transform: scale(1) } }
    </style>
    @endif
</div>
