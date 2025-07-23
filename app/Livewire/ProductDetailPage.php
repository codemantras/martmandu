<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class ProductDetailPage extends Component
{
    public string $slug;

    public function mount(string $product): void
    {
        $this->slug = $product;
    }

    public function render(): View|Application
    {
        $product = Product::where('slug', $this->slug)->firstOrFail();
        return view('livewire.product-detail-page')
            ->with(compact('product'))
            ->title('Product Detail - ' . config('app.name'));
    }
}
