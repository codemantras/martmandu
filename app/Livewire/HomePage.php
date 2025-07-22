<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use function compact;
use function config;
use function view;

class HomePage extends Component
{
    public function render(): View|Application
    {
        $brands = Brand::active()->inRandomOrder()->take(4)->get();
        $categories = Category::active()->inRandomOrder()->take(4)->get();
        return view('livewire.home-page')
            ->with(compact('brands', 'categories'))
            ->title('Home - ' . config('app.name'));
    }
}
