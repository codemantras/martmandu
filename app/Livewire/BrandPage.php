<?php

namespace App\Livewire;

use App\Models\Brand;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class BrandPage extends Component
{
    public function render(): View|Application
    {
        $brands = Brand::active()->get();
        return view('livewire.brand-page')
            ->with(compact('brands'))
            ->title('Brands - ' . config('app.name'));
    }
}
