<?php

namespace App\Livewire;

use App\Class\CartManagement;
use App\Livewire\Partial\Navbar;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class ProductDetailPage extends Component
{
    public string $slug;
    public int $quantity = 1;

    public function mount(string $product): void
    {
        $this->slug = $product;
    }

    public function increaseQuantity(): void
    {
        $this->quantity++;
        CartManagement::incrementQuantityToCartItem($this->getProduct($this->slug)->id);
    }

    public function decreaseQuantity(): void
    {
        if ($this->quantity > 1) {
            $this->quantity--;
            CartManagement::decrementQuantityToCartItem($this->getProduct($this->slug)->id);
        }
    }

    public function removeProduct(): void
    {
        Log::info("Removing product from cart");
    }

    public function addProductToCart(int $product_id): void
    {
        $total_items = CartManagement::addItemToCart($product_id, $this->quantity);
        $this->dispatch('cart-updated', total_items: $total_items)->to(Navbar::class);
        LivewireAlert::title('Product added to cart successfully!')
            ->position('bottom-end')
            ->toast()
            ->success()
            ->timer(3000)
            ->show();
    }

    public function render(): View|Application
    {
        $product = $this->getProduct($this->slug);
        return view('livewire.product-detail-page')
            ->with(compact('product'))
            ->title('Product Detail - ' . config('app.name'));
    }

    public function removeProductToCart($product_id): void
    {
        $cart_items = CartManagement::removeItemFromCart($product_id);
        $this->dispatch('cart-updated', total_items: count($cart_items))->to(Navbar::class);
        LivewireAlert::title('Product removed from cart successfully!')
            ->position('bottom-end')
            ->toast()
            ->success()
            ->timer(3000)
            ->show();

    }

    private function getProduct(string $product_slug): Product
    {
        return Product::where('slug', $this->slug)->firstOrFail();
    }
}
