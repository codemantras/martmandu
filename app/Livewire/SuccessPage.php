<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class SuccessPage extends Component
{
    public function render(): View|Application
    {
        return view('livewire.success-page');
    }
}
