<?php

// app/Livewire/Kasir/PosTerminal.php
namespace App\Livewire\Kasir;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\PaymentService;
use Livewire\Component;
use Livewire\WithPagination;

class PosTerminal extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $selectedCategory = null;
    public array $cart = [];
    public string $customerName = '';
    public string $notes = '';
    public string $paymentMethod = 'cash';
    public float $cashPaid = 0;
    public bool $showPaymentModal = false;
    public ?string $snapToken = null;
    public ?int $currentOrderId = null;

    public function addToCart(int $menuId): void
    {
        $menu = Menu::findOrFail($menuId);

        if (isset($this->cart[$menuId])) {
            $this->cart[$menuId]['quantity']++;
        } else {
            $this->cart[$menuId] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'quantity' => 1,
            ];
        }
        $this->cart[$menuId]['subtotal'] = $this->cart[$menuId]['price'] * $this->cart[$menuId]['quantity'];
    }

    public function removeFromCart(int $menuId): void
    {
        unset($this->cart[$menuId]);
    }

    public function updateQty(int $menuId, int $qty): void
    {
        if ($qty <= 0) {
            $this->removeFromCart($menuId);
            return;
        }
        $this->cart[$menuId]['quantity'] = $qty;
        $this->cart[$menuId]['subtotal'] = $this->cart[$menuId]['price'] * $qty;
    }

    public function getSubtotalProperty(): float
    {
        return collect($this->cart)->sum('subtotal');
    }

    public function getTaxProperty(): float
    {
        return $this->subtotal * 0.11;
    }

    public function getTotalProperty(): float
    {
        return $this->subtotal + $this->tax;
    }

    public function getChangeProperty(): float
    {
        return max(0, $this->cashPaid - $this->total);
    }

    public function checkout(): void
    {
        $this->validate([
            'cart' => 'required|array|min:1',
            'paymentMethod' => 'required|in:cash,midtrans',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'customer_name' => $this->customerName ?: 'Guest',
            'notes' => $this->notes,
            'status' => 'pending',
            'subtotal' => $this->subtotal,
            'tax' => $this->tax,
            'total' => $this->total,
        ]);

        $this->currentOrderId = $order->id;

        foreach ($this->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        if ($this->paymentMethod === 'midtrans') {
            $paymentService = app(PaymentService::class);
            $data = $paymentService->createSnapToken($order);
            $this->snapToken = $data['token'];
            $this->showPaymentModal = true;
        } else {
            // Cash payment langsung
            $paymentService = app(PaymentService::class);
            $paymentService->processCash($order, $this->cashPaid);
            session()->flash('success', 'Transaksi #' . $order->order_number . ' berhasil!');
            $this->resetCart();
        }
    }

    public function cancelPayment()
    {
        if ($this->currentOrderId) {
            $order = Order::find($this->currentOrderId);
            if ($order && $order->status === 'pending') {
                $order->update(['status' => 'cancelled']);
            }
        }
        // Hanya reset state pembayaran, keranjang tetap dipertahankan
        $this->showPaymentModal = false;
        $this->snapToken = null;
        $this->currentOrderId = null;
    }

    public function resetCart()
    {
        $this->cart = [];
        $this->cashPaid = 0;
        $this->showPaymentModal = false;
        $this->snapToken = null;
        $this->currentOrderId = null;
        $this->customerName = '';
        $this->notes = '';
    }

    public function render()
    {
        $menus = Menu::query()
            ->where('is_active', true)
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->selectedCategory, fn($q) => $q->where('category_id', $this->selectedCategory))
            ->with('category')
            ->paginate(12);

        $categories = \App\Models\Category::all();

        return view('livewire.kasir.pos-terminal', compact('menus', 'categories'))
            ->layout('layouts.kasir');
    }
}