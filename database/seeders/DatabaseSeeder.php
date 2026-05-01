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

        // Categories mapping
        $catIds = Category::pluck('id', 'name')->toArray();

        // Realistic Menus Data
        $realMenus = [
            [
                'category_id' => $catIds['Makanan Utama'],
                'name' => 'Nasi Goreng Spesial',
                'description' => 'Nasi goreng khas cafe dengan telur mata sapi, sosis, dan kerupuk.',
                'price' => 35000,
                'image' => '/images/menus/nasi_goreng_spesial.png'
            ],
            [
                'category_id' => $catIds['Makanan Utama'],
                'name' => 'Spaghetti Carbonara',
                'description' => 'Pasta creamy dengan potongan smoked beef dan taburan keju parmesan.',
                'price' => 45000,
                'image' => 'https://images.unsplash.com/photo-1612874742237-6526221588e3?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'category_id' => $catIds['Makanan Utama'],
                'name' => 'Chicken Cordon Bleu',
                'description' => 'Dada ayam gulung isi smoked beef dan keju mozzarella lumer dengan kentang goreng.',
                'price' => 55000,
                'image' => 'https://images.unsplash.com/photo-1598514982205-f36b96d1e8d4?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'category_id' => $catIds['Minuman Dingin'],
                'name' => 'Iced Lemon Tea',
                'description' => 'Teh lemon dingin segar dengan potongan daun mint.',
                'price' => 20000,
                'image' => '/images/menus/iced_lemon_tea.png'
            ],
            [
                'category_id' => $catIds['Minuman Dingin'],
                'name' => 'Lychee Tea',
                'description' => 'Teh segar dengan buah leci asli dan sirup manis.',
                'price' => 25000,
                'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'category_id' => $catIds['Minuman Dingin'],
                'name' => 'Iced Matcha Latte',
                'description' => 'Paduan susu segar dan bubuk matcha premium Jepang.',
                'price' => 32000,
                'image' => 'https://images.unsplash.com/photo-1536420121542-fa3f6ebc92c5?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'category_id' => $catIds['Kopi Pilihan'],
                'name' => 'Cafe Latte',
                'description' => 'Kopi espresso dengan paduan susu steam lembut dan latte art.',
                'price' => 28000,
                'image' => '/images/menus/cafe_latte.png'
            ],
            [
                'category_id' => $catIds['Kopi Pilihan'],
                'name' => 'Espresso',
                'description' => 'Single shot espresso arabika pekat dan harum.',
                'price' => 18000,
                'image' => 'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'category_id' => $catIds['Kopi Pilihan'],
                'name' => 'Caramel Macchiato',
                'description' => 'Kopi susu dengan sirup vanilla dan saus karamel manis.',
                'price' => 35000,
                'image' => 'https://images.unsplash.com/photo-1485808191679-5f86510681a2?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'category_id' => $catIds['Cemilan'],
                'name' => 'French Fries',
                'description' => 'Kentang goreng renyah dengan cocolan saus dan mayones.',
                'price' => 22000,
                'image' => '/images/menus/french_fries.png'
            ],
            [
                'category_id' => $catIds['Cemilan'],
                'name' => 'Chicken Wings',
                'description' => 'Sayap ayam goreng bumbu pedas manis ala korea.',
                'price' => 30000,
                'image' => 'https://images.unsplash.com/photo-1569691899455-88464f6d3ab1?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'category_id' => $catIds['Cemilan'],
                'name' => 'Onion Rings',
                'description' => 'Bawang bombay renyah berbalut tepung gurih.',
                'price' => 25000,
                'image' => 'https://images.unsplash.com/photo-1639024471283-03518883512d?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'category_id' => $catIds['Dessert'],
                'name' => 'Chocolate Lava Cake',
                'description' => 'Kue coklat lumer di dalam dengan es krim vanilla di atasnya.',
                'price' => 38000,
                'image' => '/images/menus/chocolate_lava.png'
            ],
            [
                'category_id' => $catIds['Dessert'],
                'name' => 'New York Cheesecake',
                'description' => 'Cheesecake lembut dengan saus strawberry segar.',
                'price' => 35000,
                'image' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'category_id' => $catIds['Dessert'],
                'name' => 'Classic Tiramisu',
                'description' => 'Dessert kopi khas Italia dengan taburan coklat bubuk premium.',
                'price' => 40000,
                'image' => 'https://images.unsplash.com/photo-1571115177098-24ecfa14a5f1?q=80&w=600&auto=format&fit=crop'
            ]
        ];

        if (Menu::count() === 0) {
            foreach ($realMenus as $m) {
                Menu::firstOrCreate(
                    ['slug' => Str::slug($m['name'])],
                    $m
                );
            }
        }

        // Generate Dummy Transactions if no orders exist
        if (Order::count() === 0) {
            $menus = Menu::all();
            if($menus->isEmpty()) return; // Failsafe
            
            for ($i = 0; $i < 50; $i++) {
                $status = collect(['paid', 'paid', 'paid', 'pending', 'cancelled'])->random();
                
                // Pick 1-4 random items
                $selectedMenus = $menus->random(rand(1, 4));
                $subtotal = 0;
                
                $order = Order::create([
                    'user_id' => $kasir->id,
                    'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                    'customer_name' => collect(['Budi', 'Siti', 'Andi', 'Dewi', 'Guest', 'Agus', 'Lina'])->random(),
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
