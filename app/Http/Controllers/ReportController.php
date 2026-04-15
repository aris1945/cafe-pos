<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function export(Request $request)
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        
        $filename = "laporan_transaksi_" . date('Y-m-d') . ".csv";
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // Header CSV
        fputcsv($handle, ['Order ID', 'Tanggal', 'Kasir', 'Pelanggan', 'Subtotal', 'Pajak', 'Total', 'Status']);
        
        foreach ($orders as $order) {
            fputcsv($handle, [
                $order->order_number,
                $order->created_at->format('Y-m-d H:i:s'),
                $order->user->name ?? 'Unknown',
                $order->customer_name ?? '-',
                $order->subtotal,
                $order->tax,
                $order->total,
                $order->status,
            ]);
        }
        
        fclose($handle);
        exit;
    }
}
