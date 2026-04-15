<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Menu;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        // 1. Kartu Cepat / Overview
        $todayRevenue = Order::where('status', 'paid')
            ->whereDate('created_at', Carbon::today())
            ->sum('total');

        $todayOrdersCount = Order::where('status', 'paid')
            ->whereDate('created_at', Carbon::today())
            ->count();
            
        $totalMenus = Menu::count();
        $totalKasir = User::where('role', 'kasir')->where('is_active', true)->count();

        // 2. Data Grafik Penjualan (7 Hari Terakhir)
        $last7Days = collect(range(6, 0))->map(function ($days) {
            return Carbon::today()->subDays($days)->format('Y-m-d');
        });

        // Ambil data total sukses dari database
        $revenueData = Order::where('status', 'paid')
            ->where('created_at', '>=', Carbon::today()->subDays(6))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total'))
            ->groupBy('date')
            ->pluck('total', 'date');

        $chartDates = [];
        $chartRevenues = [];

        foreach ($last7Days as $date) {
            $formattedDate = Carbon::parse($date)->format('d M');
            $chartDates[] = $formattedDate;
            $chartRevenues[] = $revenueData[$date] ?? 0;
        }

        // 3. Data Menu Terpopuler (Top 5 berdasarkan total qty yang terjual)
        $topMenus = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->select('menus.name', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->where('orders.status', 'paid')
            ->groupBy('menus.id', 'menus.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();
            
        $topMenuNames = $topMenus->pluck('name')->toArray();
        $topMenuQtys = $topMenus->pluck('total_qty')->map(fn($qty) => (int) $qty)->toArray();

        return view('livewire.admin.dashboard', [
            'todayRevenue' => $todayRevenue,
            'todayOrdersCount' => $todayOrdersCount,
            'totalMenus' => $totalMenus,
            'totalKasir' => $totalKasir,
            
            // Chart 1: Revenue Line
            'chartDates' => $chartDates,
            'chartRevenues' => $chartRevenues,
            
            // Chart 2: Top Selling Menu Donut
            'topMenuNames' => $topMenuNames,
            'topMenuQtys' => $topMenuQtys,
        ])->layout('layouts.admin');
    }
}
