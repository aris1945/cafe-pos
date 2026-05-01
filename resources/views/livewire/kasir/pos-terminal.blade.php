<div class="flex h-full w-full relative bg-slate-50">
    <div class="hidden" x-effect="cartCount = {{ count($cart) }}"></div>
    
    <!-- Left: Menu Grid & Controls -->
    <div class="flex-1 flex flex-col h-full overflow-hidden relative transition-all duration-300">
        
        <!-- Category & Search Bar -->
        <div class="bg-white/60 backdrop-blur-md border-b border-slate-200 px-6 py-4 z-10 flex flex-col sm:flex-row items-center justify-between gap-4 shrink-0 shadow-sm">
            <div class="flex space-x-3 overflow-x-auto w-full sm:w-auto pb-2 sm:pb-0 scrollbar-hide py-1">
                <button wire:click="$set('selectedCategory', null)" 
                    class="px-5 py-2.5 rounded-xl whitespace-nowrap text-sm font-bold transition-all duration-300 transform active:scale-95 {{ is_null($selectedCategory) ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white shadow-lg shadow-orange-500/30 border-transparent' : 'bg-white text-slate-600 hover:bg-orange-50 border border-slate-200 hover:border-orange-200 hover:text-orange-600 shadow-sm' }}">
                    🔥 Semua Menu
                </button>
                @foreach($categories as $cat)
                    <button wire:click="$set('selectedCategory', {{ $cat->id }})" 
                        class="px-5 py-2.5 rounded-xl whitespace-nowrap text-sm font-bold transition-all duration-300 transform active:scale-95 {{ $selectedCategory == $cat->id ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white shadow-lg shadow-orange-500/30 border-transparent' : 'bg-white text-slate-600 hover:bg-orange-50 border border-slate-200 hover:border-orange-200 hover:text-orange-600 shadow-sm' }}">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>
            
            <div class="relative w-full sm:w-72 shrink-0 group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-orange-500 transition-colors">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari menu spesial..." class="block w-full pl-11 pr-4 py-3 border-slate-200 rounded-xl leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all font-medium sm:text-sm shadow-sm hover:shadow-md">
            </div>
        </div>

        <!-- Catalog Grid -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 pb-28">
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-5 sm:gap-6">
                @forelse($menus as $menu)
                    @php $qtyInCart = $cart[$menu->id]['quantity'] ?? 0; @endphp
                    <div wire:key="menu-{{ $menu->id }}" wire:click="addToCart({{ $menu->id }})" class="bg-white rounded-2xl cursor-pointer border-2 transition-all duration-300 select-none overflow-hidden relative group transform hover:-translate-y-1 hover:shadow-xl hover:shadow-orange-500/10 {{ $qtyInCart > 0 ? 'border-orange-400 ring-4 ring-orange-500/20 shadow-md' : 'border-slate-100/50 shadow-sm' }}">
                        
                        @if($qtyInCart > 0)
                        <div class="absolute top-3 right-3 bg-gradient-to-br from-orange-500 to-amber-500 text-white w-9 h-9 rounded-full flex items-center justify-center font-black text-sm z-20 shadow-md shadow-orange-500/40 animate-pop border border-white/20">
                            {{ $qtyInCart }}
                        </div>
                        @else
                        <!-- Add Icon Overlay -->
                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur text-slate-700 w-9 h-9 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 z-20 shadow-sm transform translate-y-2 group-hover:translate-y-0">
                            <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                        </div>
                        @endif

                        <div class="aspect-[4/3] bg-slate-100 relative overflow-hidden">
                            @if($menu->image)
                                <img src="{{ $menu->image }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $menu->name }}">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 bg-gradient-to-br from-slate-50 to-slate-100">
                                    <svg class="w-12 h-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                        <div class="p-4 bg-white relative z-10 w-full">
                            <h3 class="font-bold text-slate-800 line-clamp-2 leading-snug mb-1.5 text-sm">{{ $menu->name }}</h3>
                            <div class="text-orange-600 font-extrabold tracking-tight">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-24 flex flex-col items-center justify-center text-slate-400">
                        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <p class="font-bold text-lg text-slate-600">Menu tidak ditemukan</p>
                        <p class="text-sm mt-1 text-slate-400">Coba kata kunci lain atau ubah kategori.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-8 flex justify-center">
                {{ $menus->links(data: ['scrollTo' => false]) }}
            </div>
        </div>
    </div>

    <!-- Right: Responsive Cart Overlay/Sidebar -->
    <div 
        class="fixed inset-y-0 right-0 z-50 w-[85%] sm:w-[420px] bg-white flex flex-col shadow-[-20px_0_40px_-10px_rgba(0,0,0,0.15)] transition-transform duration-300 ease-in-out transform"
        :class="cartOpen ? 'translate-x-0' : 'translate-x-full'"
    >
        <!-- Custom Close Btn Mobile -->
        <button @click="cartOpen = false" class="sm:hidden absolute top-4 -left-14 z-50 bg-white p-3 text-slate-600 rounded-xl shadow-lg border border-slate-100 hover:text-orange-600 hover:bg-orange-50 transition-colors">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </button>

        <!-- Cart Header -->
        <div class="p-5 border-b border-slate-100 bg-white shadow-sm shrink-0 flex items-center justify-between">
            <h2 class="text-xl font-extrabold text-slate-800 flex items-center gap-3">
                Keranjang 
                <span class="bg-orange-100 text-orange-600 px-2.5 py-0.5 rounded-lg text-sm">{{ count($cart) }}</span>
            </h2>
            <div class="flex items-center gap-3">
                <button wire:click="resetCart" class="text-xs font-bold text-red-500 hover:text-white bg-red-50 hover:bg-red-500 px-3 py-1.5 rounded-lg transition-colors">
                    Reset
                </button>
                <button @click="cartOpen = false" class="hidden sm:flex text-slate-400 hover:text-red-500 hover:bg-red-50 p-1 rounded transition-colors" title="Tutup Keranjang">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>
        
        <!-- Scrollable Content Area -->
        <div class="flex-1 overflow-y-auto bg-slate-50 flex flex-col relative">
            
            <!-- Customer Input -->
            <div class="px-5 py-4 bg-white border-b border-slate-100 shrink-0 shadow-sm z-10 relative">
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 group-focus-within:text-orange-500">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <input type="text" wire:model="customerName" placeholder="Nama Pelanggan (Optional)" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-shadow text-sm font-bold shadow-inner placeholder-slate-400 text-slate-800">
                </div>
            </div>

            <!-- Cart Items list -->
            <div class="p-5 space-y-3 relative {{ empty($cart) ? 'flex-1 flex items-center justify-center' : 'shrink-0' }}">
                @if(empty($cart))
                    <div class="flex flex-col items-center justify-center text-slate-400">
                        <div class="w-24 h-24 bg-white border border-slate-100 rounded-full flex items-center justify-center mb-4 shadow-sm">
                            <svg class="w-12 h-12 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <p class="font-bold text-slate-500 text-lg">Keranjang Kosong</p>
                        <p class="text-sm mt-1">Pilih pesanan pelanggan Anda.</p>
                    </div>
                @else
                    @foreach($cart as $id => $item)
                        <div wire:key="cart-{{ $id }}" class="bg-white border text-sm border-slate-100 rounded-2xl p-3 shadow-sm flex items-center gap-3 relative overflow-hidden group transition-all hover:shadow-md hover:border-orange-200">
                            <!-- Red delete strip on hover -->
                            <button wire:click="removeFromCart({{ $id }})" class="absolute top-0 right-0 bottom-0 bg-red-500 w-12 flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-all translate-x-full group-hover:translate-x-0 cursor-pointer border-none z-10 hover:bg-red-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>

                            <div class="flex-1 min-w-0 pr-8">
                                <h4 class="font-bold text-slate-800 leading-tight whitespace-nowrap overflow-hidden text-ellipsis mb-1">{{ $item['name'] }}</h4>
                                <div class="text-orange-500 border border-orange-100 bg-orange-50 w-max px-2 py-0.5 rounded font-bold tracking-tight text-xs">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                            </div>
                            
                            <div class="flex items-center gap-1 shrink-0 bg-slate-50 p-1 border border-slate-100 rounded-lg shadow-inner z-0">
                                <button wire:click="updateQty({{ $id }}, {{ $item['quantity'] - 1 }})" class="w-7 h-7 flex items-center justify-center bg-white rounded shadow-sm text-slate-500 hover:text-white hover:bg-orange-500 border border-slate-200 hover:border-orange-500 font-black active:scale-95 transition-all">
                                    &minus;
                                </button>
                                <span class="font-extrabold min-w-[24px] text-center text-slate-800">{{ $item['quantity'] }}</span>
                                <button wire:click="updateQty({{ $id }}, {{ $item['quantity'] + 1 }})" class="w-7 h-7 flex items-center justify-center bg-white rounded shadow-sm text-slate-500 hover:text-white hover:bg-orange-500 border border-slate-200 hover:border-orange-500 font-black active:scale-95 transition-all">
                                    &plus;
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Totals & Payment Info -->
            <div class="bg-white border-t border-slate-100 p-5 flex flex-col gap-4 mt-auto">
                <div class="space-y-2.5 mb-1">
                    <div class="flex justify-between text-slate-500 font-semibold text-sm">
                        <span>Subtotal</span>
                        <span class="text-slate-800">Rp {{ number_format($this->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-slate-500 font-semibold text-sm">
                        <span>PPN (11%)</span>
                        <span class="text-slate-800">Rp {{ number_format($this->tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-end pt-3 border-t border-slate-200 border-dashed mt-2">
                        <span class="text-slate-500 font-bold text-sm uppercase tracking-wider">Total Pembayaran</span>
                        <span class="text-right text-orange-600 font-black text-2xl leading-none">Rp {{ number_format($this->total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 mt-1">
                    <label class="block cursor-pointer relative">
                        <input type="radio" name="paymentGroup" wire:model.live="paymentMethod" value="cash" class="peer sr-only">
                        <div class="p-3 bg-white border-2 border-slate-100 rounded-xl text-center peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:text-orange-700 transition-all font-bold text-slate-500 active:scale-95 flex flex-col items-center gap-1.5 shadow-sm">
                            <svg class="w-6 h-6 peer-checked:animate-bounce-short" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            <span class="text-xs uppercase tracking-wide">Tunai (Cash)</span>
                        </div>
                    </label>
                    <label class="block cursor-pointer relative">
                        <input type="radio" name="paymentGroup" wire:model.live="paymentMethod" value="midtrans" class="peer sr-only">
                        <div class="p-3 bg-white border-2 border-slate-100 rounded-xl text-center peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:text-orange-700 transition-all font-bold text-slate-500 active:scale-95 flex flex-col items-center gap-1.5 shadow-sm">
                            <svg class="w-6 h-6 peer-checked:animate-bounce-short" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                            <span class="text-xs uppercase tracking-wide">Qris / Bank</span>
                        </div>
                    </label>
                </div>

                @if($paymentMethod === 'cash')
                    <div class="bg-white p-4 border-2 border-slate-100 rounded-xl shadow-sm mt-1 relative overflow-hidden transition-all animate-pop">
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gradient-to-b from-orange-400 to-amber-500"></div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 pl-3">Uang Diterima</label>
                        <div class="relative pl-2">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 font-bold text-lg">Rp</div>
                            <input type="number" wire:model.live.debounce.1000ms="cashPaid" class="w-full pl-11 border-slate-200 rounded-lg focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 font-black text-2xl py-3 px-3 shadow-inner bg-slate-50 text-slate-800 transition-all">
                        </div>
                        
                        @if($cashPaid > 0)
                            <div class="flex justify-between items-center mt-4 pt-3 border-t border-slate-100 pl-3">
                                <span class="text-sm font-bold text-slate-400 uppercase tracking-wider">Kembali:</span>
                                <span class="font-black text-xl bg-clip-text text-transparent {{ $this->change < 0 ? 'bg-gradient-to-r from-red-500 to-rose-600' : 'bg-gradient-to-r from-emerald-500 to-teal-500' }}">
                                    Rp {{ number_format($this->change, 0, ',', '.') }}
                                </span>
                            </div>
                        @endif
                    </div>
                @endif

                <textarea wire:model="notes" rows="1" placeholder="Catatan pesanan..." class="w-full border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 text-sm shadow-sm py-3 px-4 bg-slate-50 form-textarea font-medium placeholder-slate-400 transition-shadow mt-1 mb-2"></textarea>
            </div>
        </div>
        
        <!-- Sticky Checkout Button Action -->
        <div class="p-5 bg-white border-t border-slate-200 shadow-[0_-15px_25px_-5px_rgba(0,0,0,0.05)] z-20 shrink-0">
            <button wire:click="checkout" 
                @if(empty($cart) || ($paymentMethod === 'cash' && $cashPaid < $this->total)) disabled @endif
                class="w-full py-4 text-white font-black text-lg rounded-xl shadow-xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none uppercase tracking-widest relative overflow-hidden group
                {{ empty($cart) ? 'bg-slate-400 shadow-none' : 'bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 hover:shadow-orange-500/40 transform active:scale-[0.98]' }}">
                
                @if($paymentMethod==='midtrans')
                    <span class="flex items-center justify-center gap-2">
                       <svg class="w-6 h-6 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                       Buat QRIS / Bayar
                    </span>
                @else
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-6 h-6 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Checkout Order
                    </span>
                @endif
                
                <!-- Shine effect -->
                <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/30 to-transparent group-hover:animate-shine"></div>
            </button>
            
            @if (session()->has('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="absolute bottom-6 left-5 right-5 text-emerald-800 bg-emerald-50 p-4 rounded-xl text-center border-2 border-emerald-400 font-black shadow-2xl animate-fade-in-up z-50 flex items-center justify-center gap-2">
                    <svg class="w-7 h-7 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Back-Drop for Cart overlay -->
    <div x-show="cartOpen" x-transition.opacity @click="cartOpen = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40" style="display: none;"></div>

    @if($showPaymentModal && $snapToken)
        <div x-data x-init="
            if (typeof window.snap !== 'undefined') {
                window.snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result){ alert('Pembayaran berhasil!'); $wire.resetCart(); },
                    onPending: function(result){ alert('Menunggu pembayaran Anda...'); $wire.resetCart(); },
                    onError: function(result){ alert('Pembayaran gagal!'); $wire.cancelPayment(); },
                    onClose: function(){ alert('Anda menutup transaksi.'); $wire.cancelPayment(); }
                });
            } else { alert('Gateway pembayaran tidak dimuat. Coba lagi.'); }
        "></div>
    @endif
    
    <style>
        .animate-pop { animation: pop 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        @keyframes pop { 0% { transform: scale(0.5); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
        .animate-shine { animation: shine 2s ease-in-out infinite; }
        @keyframes shine { 100% { transform: translateX(100%); } }
        .animate-bounce-short { animation: bounce-short 0.5s ease-in-out 1; }
        @keyframes bounce-short { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-5px); } }
        .animate-fade-in-up { animation: fadeInUp 0.4s ease-out; }
        @keyframes fadeInUp { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</div>
