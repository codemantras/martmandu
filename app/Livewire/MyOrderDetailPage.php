<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class MyOrderDetailPage extends Component
{
    public function render(): View|Application
    {
        return view('livewire.my-order-detail-page');
    }
}
