<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\OrderResource\Widgets\OderStatus;
use App\Models\Order;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make(),];
    }

    protected function getHeaderWidgets(): array
    {
        return [OderStatus::class];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make("All"),
            "pending" => Tab::make('Pending')->query(fn($query) => $query->whereIn('status', ['new', 'pending', 'processing'])),
            "shipped" => Tab::make('Shipped')->query(fn($query) => $query->where('status', 'shipped')),
            "completed" => Tab::make('Completed')->query(fn($query) => $query->where('status', 'completed')),
            "cancelled" => Tab::make('Cancelled')->query(fn($query) => $query->where('status', 'cancelled')),
        ];
    }
}
