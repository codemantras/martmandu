<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use function config;

class ProductsPage extends Component
{
    public function render(): View|Application
    {
        return view('livewire.products-page')
            ->title('Products - ' . config('app.name'));
    }
}
