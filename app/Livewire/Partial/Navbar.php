<?php

namespace App\Livewire\Partial;

use App\Class\CartManagement;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Component;
use function count;

class Navbar extends Component
{
    public int $cart_count = 0;

    public function mount(): void
    {
        $this->cart_count = count(CartManagement::getCartItemsFromCookie());
    }

    #[On('cart-updated')]
    public function updateCartList(int $total_items): void
    {
        $this->cart_count = $total_items;
    }

    public function render(): View|Application
    {
        return view('livewire.partial.navbar');
    }
}
