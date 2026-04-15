<div>
    <x-slot name="header">Overview Analisis Bisnis</x-slot>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Revenue Today -->
        <div class="bg-gradient-to-br from-orange-400 to-orange-600 text-white p-6 rounded-2xl shadow-xl shadow-orange-500/20 border border-orange-500/50 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/20 rounded-full blur-xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="flex items-center gap-4 relative z-10">
                <div class="bg-white/20 p-3 rounded-xl border border-white/30 backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-orange-100 mb-1">Pendapatan Hari Ini</h3>
                    <div class="text-2xl font-black">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <!-- Orders Today -->
        <div class="bg-white p-6 rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 relative group overflow-hidden">
            <div class="absolute bottom-0 right-0 w-24 h-24 bg-gradient-to-tl from-amber-100 to-transparent rounded-tl-full opacity-50 group-hover:scale-125 transition-transform duration-500"></div>
            <div class="flex items-center gap-4 relative z-10">
                <div class="bg-amber-50 p-3 rounded-xl border border-amber-100 text-amber-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                </div>
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Pemesanan Hari Ini</h3>
                    <div class="text-2xl font-black text-slate-800">{{ $todayOrdersCount }} <span class="text-sm text-slate-400 font-medium ml-1">Transaksi</span></div>
                </div>
            </div>
        </div>

        <!-- Total Menus -->
        <div class="bg-white p-6 rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 relative group overflow-hidden">
            <div class="absolute bottom-0 right-0 w-24 h-24 bg-gradient-to-tl from-emerald-100 to-transparent rounded-tl-full opacity-50 group-hover:scale-125 transition-transform duration-500"></div>
            <div class="flex items-center gap-4 relative z-10">
                <div class="bg-emerald-50 p-3 rounded-xl border border-emerald-100 text-emerald-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                </div>
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Total Menu Aktif</h3>
                    <div class="text-2xl font-black text-slate-800">{{ $totalMenus }} <span class="text-sm text-slate-400 font-medium ml-1">Varian</span></div>
                </div>
            </div>
        </div>

        <!-- Active Cashiers -->
        <div class="bg-white p-6 rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 relative group overflow-hidden">
            <div class="absolute bottom-0 right-0 w-24 h-24 bg-gradient-to-tl from-blue-100 to-transparent rounded-tl-full opacity-50 group-hover:scale-125 transition-transform duration-500"></div>
            <div class="flex items-center gap-4 relative z-10">
                <div class="bg-blue-50 p-3 rounded-xl border border-blue-100 text-blue-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Kasir Aktif</h3>
                    <div class="text-2xl font-black text-slate-800">{{ $totalKasir }} <span class="text-sm text-slate-400 font-medium ml-1">User</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Revenue Area Chart -->
        <div class="bg-white p-6 flex flex-col justify-between rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 lg:col-span-2 relative overflow-hidden group hover:shadow-orange-500/10 transition-shadow">
            <div>
                <h3 class="font-bold text-xl text-slate-800 mb-1">Tren Penjualan Mingguan</h3>
                <p class="text-sm text-slate-500 mb-2">Analisa fluktuasi total pendapatan selama 7 hari terakhir.</p>
            </div>
            
            <div wire:ignore class="flex-1 mt-2">
                <div id="revenueChart" class="w-full"></div>
            </div>
        </div>

        <!-- Top Selling Menus Donut Chart -->
        <div class="bg-white p-6 flex flex-col justify-between rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 relative overflow-hidden group hover:shadow-orange-500/10 transition-shadow">
            <div>
                <h3 class="font-bold text-xl text-slate-800 mb-1">Top 5 Menu Laris</h3>
                <p class="text-sm text-slate-500 mb-2">Persentase produk yang paling sukses dijual sepanjang waktu.</p>
            </div>
            
            <div wire:ignore class="flex-1 flex items-center justify-center">
                <div id="topMenuChart" class="w-full relative flex items-center justify-center"></div>
            </div>
        </div>
    </div>

    <!-- Load ApexCharts Script dynamically via Alpine data component -->
    <div x-data="dashboardCharts" x-init="initCharts()"></div>
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dashboardCharts', () => ({
                initCharts() {
                    if (typeof window.ApexCharts === 'undefined') {
                        let script = document.createElement('script');
                        script.src = 'https://cdn.jsdelivr.net/npm/apexcharts';
                        script.onload = () => {
                            this.renderAllCharts();
                        };
                        document.head.appendChild(script);
                    } else {
                        this.renderAllCharts();
                    }
                },
                renderAllCharts() {
                    let chartDates = {!! json_encode($chartDates) !!};
                    let chartRevenues = {{ json_encode($chartRevenues) }};
                    
                    let topMenuNames = {!! empty($topMenuNames) ? '["Belum Ada Data"]' : json_encode($topMenuNames) !!};
                    let topMenuQtys = {{ empty($topMenuQtys) ? '[1]' : json_encode($topMenuQtys) }};
                    let isTopMenuEmpty = {{ empty($topMenuQtys) ? 'true' : 'false' }};

                    var revenueOptions = {
                        chart: {
                            type: 'area',
                            height: 320,
                            fontFamily: 'Outfit, sans-serif',
                            toolbar: { show: false },
                            zoom: { enabled: false }
                        },
                        series: [{
                            name: 'Pendapatan',
                            data: chartRevenues
                        }],
                        xaxis: {
                            categories: chartDates,
                            labels: { style: { colors: '#94a3b8', fontWeight: 600 } },
                            axisBorder: { show: false },
                            axisTicks: { show: false }
                        },
                        yaxis: {
                            labels: {
                                style: { colors: '#94a3b8', fontWeight: 600 },
                                formatter: (val) => { return 'Rp ' + val.toLocaleString('id-ID'); }
                            }
                        },
                        dataLabels: { enabled: false },
                        stroke: {
                            curve: 'smooth',
                            width: 4,
                            colors: ['#f97316']
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.45,
                                opacityTo: 0.05,
                                stops: [0, 100],
                                colorStops: [
                                    { offset: 0, color: '#f97316', opacity: 0.4 },
                                    { offset: 100, color: '#f97316', opacity: 0.0 }
                                ]
                            }
                        },
                        tooltip: {
                            theme: 'light',
                            y: { formatter: function (val) { return 'Rp ' + val.toLocaleString('id-ID') } }
                        },
                        grid: {
                            borderColor: '#f1f5f9',
                            strokeDashArray: 4,
                            padding: { top: 0, right: 0, bottom: 0, left: 10 }
                        }
                    };

                    setTimeout(() => {
                        var revEl = document.querySelector('#revenueChart');
                        if(revEl) {
                            revEl.innerHTML = '';
                            var revenueChart = new ApexCharts(revEl, revenueOptions);
                            revenueChart.render();
                        }
                    }, 50);

                    var topMenuOptions = {
                        chart: {
                            type: 'donut',
                            height: 300,
                            fontFamily: 'Outfit, sans-serif',
                        },
                        series: topMenuQtys,
                        labels: topMenuNames,
                        colors: isTopMenuEmpty ? ['#e2e8f0'] : ['#f97316', '#fbbf24', '#34d399', '#60a5fa', '#a78bfa'],
                        dataLabels: { enabled: false },
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '70%',
                                    labels: {
                                        show: true,
                                        name: { fontSize: '13px', color: '#64748b', fontWeight: 700 },
                                        value: {
                                            fontSize: '26px',
                                            fontWeight: 900,
                                            color: '#0f172a',
                                            formatter: function (val) { return (isTopMenuEmpty ? '0' : val) + ' Pcs' }
                                        },
                                        total: {
                                            show: true,
                                            label: 'Total Terjual',
                                            fontWeight: 800,
                                            color: '#f97316'
                                        }
                                    }
                                }
                            }
                        },
                        stroke: { show: true, colors: '#fff', width: 4 },
                        legend: { show: false },
                        tooltip: {
                            enabled: !isTopMenuEmpty,
                            y: { formatter: function (val) { return val + ' Porsi' } }
                        }
                    };
                    
                    setTimeout(() => {
                        var donutEl = document.querySelector('#topMenuChart');
                        if(donutEl) {
                            donutEl.innerHTML = '';
                            var topMenuChart = new ApexCharts(donutEl, topMenuOptions);
                            topMenuChart.render();
                        }
                    }, 50);
                }
            }));
        });
    </script>
</div>
