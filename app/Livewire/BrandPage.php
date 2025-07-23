<?php

namespace App\Livewire;

use App\Models\Brand;
use Livewire\Component;

class BrandPage extends Component
{
    public function render()
    {
        $brands = Brand::active()->get();
        return view('livewire.brand-page')
            ->with(compact('brands'))
            ->title('Brands - ' . config('app.name'));
    }
}
