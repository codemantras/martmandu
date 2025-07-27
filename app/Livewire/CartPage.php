<?php

namespace App\Livewire;

use App\Class\CartManagement;
use App\Livewire\Partial\Navbar;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use function json_encode;

class CartPage extends Component
{
    public array $cart_items = [];
    public int $grand_total = 0;

    public function mount(): void
    {
        $this->cart_items = CartManagement::getCartItemsFromCookie();
        $this->grand_total = CartManagement::cartItemGrandTotal($this->cart_items);
    }

    public function render(): View|Application
    {
        return view('livewire.cart-page')
            ->title('Cart - ' . env('APP_NAME'));
    }

    public function decreaseQuantity(int $product_id): void
    {
        $cart_item=CartManagement::getCartItem($product_id);
        if($cart_item){

        }
        $this->cart_items=CartManagement::decrementQuantityToCartItem($product_id);
        $this->grand_total = CartManagement::cartItemGrandTotal($this->cart_items);
    }


    public function increaseQuantity(int $product_id): void
    {
        $this->cart_items=CartManagement::incrementQuantityToCartItem($product_id);
        $this->grand_total = CartManagement::cartItemGrandTotal($this->cart_items);
    }

    public function removeItemFromCart(int $product_id): void
    {
        Log::info("Removing $product_id from cart");
        $this->cart_items = CartManagement::removeItemFromCart($product_id);
        $this->grand_total = CartManagement::cartItemGrandTotal($this->cart_items);
        $this->dispatch('cart-updated', total_items: count($this->cart_items))->to(Navbar::class);
    }
}
