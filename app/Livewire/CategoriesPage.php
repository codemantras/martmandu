<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use function config;

class CategoriesPage extends Component
{
    public function render(): View|Application
    {
        return view('livewire.categories-page')
            ->title('Categories - ' . config('app.name'));
    }
}
