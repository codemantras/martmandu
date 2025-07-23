<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
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
        if ($this->selected_brand) {
            $products->whereHas('brand', fn ($query) => $query->whereIn('slug', $this->selected_brand));
        }

        if ($this->selected_category) {
            $products->whereHas('category', fn ($query) => $query->whereIn('slug', $this->selected_category));
        }

        if ($this->featured) {
            $products->is_featured();
        }

        if ($this->sale) {
            $products->on_sale();
        }

        if ($this->price_range) {
            $products->whereBetween('price', [0, $this->price_range]);
        }

        return $products;
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
