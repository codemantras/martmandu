<?php

namespace App\Livewire;

use App\Class\CartManagement;
use App\Livewire\Partial\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use function config;

class ProductsPage extends Component
{
    use WithPagination;

    #[Url]
    public array $selected_category = [], $selected_brand = [];
    #[Url]
    public bool $featured = false, $sale = false;
    #[Url]
    public int $price_range = 3000;
    #[Url]
    public string $sort = 'latest';

    public function addProductToCart(int $product_id): void
    {
        $total_items = CartManagement::addItemToCart($product_id);
        $this->dispatch('cart-updated', total_items: $total_items)->to(Navbar::class);
        LivewireAlert::title('Product added to card successfully!')
            ->toast()
            ->success()
            ->timer(3000)
            ->position('bottom-end')
            ->show();
    }

    public function render(): View|Application
    {
        $products = $this->filteredProducts(Product::active())->paginate(9);

        return view('livewire.products-page')
            ->with([
                'products' => $products,
                'categories' => $this->activeCategories(),
                'brands' => $this->activeBrands(),
            ])
            ->title('Products - ' . config('app.name'));
    }

    protected function filteredProducts(Builder $products): Builder
    {
        return $products
            ->when($this->selected_brand, fn($query) => $query->whereHas('brand', fn($q) => $q->whereIn('slug', $this->selected_brand)))
            ->when($this->selected_category, fn($query) => $query->whereHas('category', fn($q) => $q->whereIn('slug', $this->selected_category)))
            ->when($this->featured, fn($query) => $query->is_featured())
            ->when($this->sale, fn($query) => $query->on_sale())
            ->when($this->price_range, fn($query) => $query->whereBetween('price', [0, $this->price_range]))
            ->when($this->sort === 'latest', fn($query) => $query->latest())
            ->when($this->sort === 'price', fn($query) => $query->orderBy('price'));
    }

    protected function activeCategories(): Collection
    {
        return Category::active()->get(['id', 'name', 'slug']);
    }

    protected function activeBrands(): Collection
    {
        return Brand::active()->get(['id', 'name', 'slug']);
    }
}
