<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use function config;

class LoginPage extends Component
{
    public function render(): View|Application
    {
        return view('livewire.login-page')
            ->title('Login - ' . config('app.name'));
    }
}
