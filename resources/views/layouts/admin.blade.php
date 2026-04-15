<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Cafe') }} Admin</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Outfit:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <style>
            body { font-family: 'Outfit', sans-serif; }
            .scrollbar-hide::-webkit-scrollbar { display: none; }
            .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        </style>
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-800 flex h-screen overflow-hidden selection:bg-orange-200 selection:text-orange-900" x-data="{ sidebarOpen: false }">
        
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm md:hidden" @click="sidebarOpen = false" style="display: none;"></div>

        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-72 bg-[#1e293b] text-slate-300 transition-transform duration-300 ease-in-out transform flex flex-col shadow-2xl md:translate-x-0 md:static md:shrink-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
               
            <!-- Branding -->
            <div class="h-20 flex items-center px-8 bg-[#0f172a] shadow-md border-b border-slate-800/50">
                <div class="flex items-center gap-3">
                    <div class="bg-gradient-to-br from-orange-400 to-orange-600 text-white p-2 rounded-lg shadow-lg shadow-orange-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <h2 class="text-2xl font-extrabold tracking-tight text-white">Cafe<span class="text-orange-500">Admin</span></h2>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5 scrollbar-hide">
                <p class="px-4 text-xs font-bold uppercase tracking-widest text-slate-500 mb-3 mt-2">Menu Utama</p>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500/10 text-orange-500' : 'hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-orange-500' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.kasir') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->routeIs('admin.kasir') ? 'bg-orange-500/10 text-orange-500' : 'hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.kasir') ? 'text-orange-500' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    Kelola Kasir
                </a>
                
                <p class="px-4 text-xs font-bold uppercase tracking-widest text-slate-500 mb-3 mt-8">Manajemen Entitas</p>

                <a href="{{ route('admin.categories') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->routeIs('admin.categories') ? 'bg-orange-500/10 text-orange-500' : 'hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.categories') ? 'text-orange-500' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                    Kategori Menu
                </a>
                
                <a href="{{ route('admin.menus') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->routeIs('admin.menus') ? 'bg-orange-500/10 text-orange-500' : 'hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.menus') ? 'text-orange-500' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                    Daftar Menu
                </a>
                
                <p class="px-4 text-xs font-bold uppercase tracking-widest text-slate-500 mb-3 mt-8">Keuangan</p>

                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->routeIs('admin.reports.*') ? 'bg-orange-500/10 text-orange-500' : 'hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.reports.*') ? 'text-orange-500' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    Laporan Penjualan
                </a>
            </div>

            <!-- Profile & Logout Bottom -->
            <div class="px-6 py-5 bg-[#0f172a] border-t border-slate-800/50">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center text-white font-bold text-lg">
                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="ml-3 truncate">
                        <p class="text-sm font-bold text-white">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs font-medium text-slate-400">Administrator</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2 rounded-lg bg-slate-800 hover:bg-red-500/20 text-slate-300 hover:text-red-400 border border-slate-700 hover:border-red-500/30 font-medium transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Mobile Top Bar -->
            <header class="md:hidden flex items-center justify-between px-6 h-20 bg-white border-b border-slate-200 shrink-0 shadow-sm z-30">
                <div class="flex items-center gap-2">
                    <div class="bg-gradient-to-br from-orange-400 to-orange-600 text-white p-1.5 rounded-lg shadow">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <h2 class="text-xl font-extrabold text-slate-800">Cafe<span class="text-orange-500">Admin</span></h2>
                </div>
                <button @click="sidebarOpen = true" class="text-slate-600 hover:text-orange-500 focus:outline-none p-2 rounded-lg hover:bg-slate-50 transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-slate-50 p-4 md:p-8 relative">
                @if(isset($header))
                    <div class="mb-8">
                        <h1 class="text-2xl font-black text-slate-800">{{ $header }}</h1>
                        <div class="h-1 w-10 bg-orange-500 rounded mt-2"></div>
                    </div>
                @endif
                
                {{ $slot }}
            </main>
        </div>
        
        @livewireScripts
    </body>
</html>
