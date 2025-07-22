<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use function config;

class HomePage extends Component
{
    public function render(): View|Application
    {
        return view('livewire.home-page')
            ->title('Home - ' . config('app.name'));
    }
}
