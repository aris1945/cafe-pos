<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;

class ReportDashboard extends Component
{
    public $selectedOrder = null;
    public $showModal = false;

    public function showOrderDetails($orderId)
    {
        $this->selectedOrder = Order::with(['items.menu', 'user', 'payment'])->find($orderId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedOrder = null;
    }

    public function render()
    {
        $totalRevenue = Order::where('status', 'paid')->sum('total');
        $totalOrders = Order::where('status', 'paid')->count();
        $recentOrders = Order::with('user')->orderBy('created_at', 'desc')->take(10)->get();

        return view('livewire.admin.report-dashboard', compact('totalRevenue', 'totalOrders', 'recentOrders'))
               ->layout('layouts.admin');
    }
}
