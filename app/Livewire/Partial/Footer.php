<?php

namespace App\Livewire\Partial;

use App\Class\CartManagement;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Footer extends Component
{
    public function render(): View|Application
    {
        return view('livewire.partial.footer');
    }
}
