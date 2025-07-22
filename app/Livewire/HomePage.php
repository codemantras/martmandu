<?php

namespace App\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class HomePage extends Component
{
    public function render(): View|Application
    {
        return view('livewire.home-page');
    }
}
