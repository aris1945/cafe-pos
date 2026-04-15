<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Kasir POS - {{ config('app.name', 'Cafe') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Outfit:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <style>
            body { font-family: 'Outfit', sans-serif; }
            .glass-header {
                background: rgba(255, 255, 255, 0.75);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border-bottom: 1px solid rgba(255,255,255,0.4);
            }
        </style>
    </head>
    <body class="bg-slate-50 text-slate-800 h-screen overflow-hidden flex flex-col selection:bg-orange-200 selection:text-orange-900" x-data="{ cartOpen: false, cartCount: 0 }">
        
        <!-- Header -->
        <header class="glass-header shadow-[0_4px_30px_rgba(0,0,0,0.03)] z-40 flex shrink-0 sticky top-0 transition-all">
            <div class="flex items-center justify-between px-6 py-4 w-full">
                <div class="flex items-center gap-3">
                    <div class="bg-gradient-to-br from-orange-400 to-orange-600 text-white p-2.5 rounded-xl shadow-lg shadow-orange-500/30">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-extrabold tracking-tight text-slate-800 leading-tight">Cafe<span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-amber-500">POS</span></h1>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest">{{ now()->format('d M Y') }}</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-5">
                    <!-- Cart Button (Ecommerce style) -->
                    <button @click="cartOpen = !cartOpen" class="relative p-2 text-slate-500 hover:text-orange-500 transition-colors focus:outline-none">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        <span x-show="cartCount > 0" x-text="cartCount" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-[10px] font-bold shadow animate-pop" style="display: none;"></span>
                    </button>
                    <div class="h-8 w-px bg-slate-200"></div>
                    <div class="hidden sm:flex flex-col items-end">
                        <span class="font-bold text-sm text-slate-800">{{ auth()->user()->name ?? 'Kasir' }}</span>
                        <span class="text-xs font-bold text-orange-600 bg-orange-100 px-2 py-0.5 mt-0.5 rounded-md">Kasir Aktif</span>
                    </div>
                    <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="group flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all duration-300">
                            <svg class="w-6 h-6 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        </button>
                    </form>
                </div>
            </div>
        </header>
        
        <main class="flex-1 overflow-hidden relative">
            {{ $slot }}
        </main>
        
        @livewireScripts
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    </body>
</html>
