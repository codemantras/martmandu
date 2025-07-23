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
        $products = $this->filteredProducts()->paginate(9);

        return view('livewire.products-page')
            ->with([
                'products' => $products,
                'categories' => $this->activeCategories(),
                'brands' => $this->activeBrands(),
            ])
            ->title('Products - ' . config('app.name'));
    }

    protected function filteredProducts(): Builder
    {
        $query = Product::active();

        if ($this->selected_brand) {
            $query->whereIn('brand_id', $this->selectedBrandIds());
        }

        if ($this->selected_category) {
            $query->whereIn('category_id', $this->selectedCategoryIds());
        }

        if ($this->featured) {
            $query->where('is_featured', $this->featured);
        }

        if ($this->sale) {
            $query->where('on_sale', $this->sale);
        }

        if ($this->price_range) {
            $query->whereBetween('price', [0, $this->price_range]);
        }

        return $query;
    }

    protected function selectedBrandIds(): Collection
    {
        return Brand::active()
            ->whereIn('slug', $this->selected_brand)
            ->pluck('id');
    }

    protected function selectedCategoryIds(): Collection
    {
        return Category::active()
            ->whereIn('slug', $this->selected_category)
            ->pluck('id');
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
