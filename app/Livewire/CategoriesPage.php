<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use function config;

class CategoriesPage extends Component
{
    public function render(): View|Application
    {
        $categories = Category::active()->get();
        return view('livewire.categories-page')
            ->with(compact('categories'))
            ->title('Categories - ' . config('app.name'));
    }
}
