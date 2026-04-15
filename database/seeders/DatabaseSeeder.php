<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@cafe.com'],
            ['name' => 'Administrator', 'password' => bcrypt('password'), 'role' => 'admin']
        );

        // Kasir
        $kasir = User::firstOrCreate(
            ['email' => 'kasir@cafe.com'],
            ['name' => 'Kasir 1', 'password' => bcrypt('password'), 'role' => 'kasir']
        );

        // Categories
        $categories = ['Makanan Utama', 'Minuman Dingin', 'Kopi Pilihan', 'Cemilan', 'Dessert'];
        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => Str::slug($cat)], ['name' => $cat]);
        }

        // Generate 36 Menus
        if (Menu::count() === 0) {
            Menu::factory(36)->create();
        }

        // Generate Dummy Transactions if no orders exist
        if (Order::count() === 0) {
            $menus = Menu::all();
            for ($i = 0; $i < 50; $i++) {
                $status = collect(['paid', 'paid', 'paid', 'pending', 'cancelled'])->random();
                
                // Pick 1-4 random items
                $selectedMenus = $menus->random(rand(1, 4));
                $subtotal = 0;
                
                $order = Order::create([
                    'user_id' => $kasir->id,
                    'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                    'customer_name' => collect(['Budi', 'Siti', 'Andi', 'Dewi', 'Guest'])->random(),
                    'status' => $status,
                    'subtotal' => 0,
                    'tax' => 0,
                    'total' => 0,
                    'notes' => 'Seeded data',
                    'created_at' => now()->subDays(rand(0, 30))->subMinutes(rand(10, 600)),
                ]);

                foreach ($selectedMenus as $menu) {
                    $qty = rand(1, 3);
                    $itemSubtotal = $menu->price * $qty;
                    $subtotal += $itemSubtotal;
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'menu_id' => $menu->id,
                        'quantity' => $qty,
                        'price' => $menu->price,
                        'subtotal' => $itemSubtotal,
                    ]);
                }

                $tax = $subtotal * 0.11;
                $total = $subtotal + $tax;

                $order->update([
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'total' => $total,
                ]);

                if ($status === 'paid') {
                    Payment::create([
                        'order_id' => $order->id,
                        'transaction_id' => 'TRX-' . strtoupper(Str::random(10)),
                        'method' => collect(['cash', 'qris'])->random(),
                        'amount' => collect([$total, $total, $total, $total + 50000])->random(), // sometimes exact change, sometimes more
                        'status' => 'success',
                        'paid_at' => $order->created_at->addMinutes(rand(1, 5)),
                        'created_at' => $order->created_at->addMinutes(rand(1, 5)),
                    ]);
                }
            }
        }
    }
}
