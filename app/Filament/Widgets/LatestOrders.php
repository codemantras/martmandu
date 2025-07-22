<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OrderResource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('-created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label("Order ID")
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label("Customer name")
                    ->searchable(),
                TextColumn::make('grand_total'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'new' => 'info',
                        'pending' => 'warning',
                        'processing' => 'warning',
                        'shipped' => 'success',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                    })
                    ->sortable(),
                TextColumn::make('payment_method')
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->sortable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'failed' => 'danger',
                    }),
                TextColumn::make('created_at')
                    ->label("Order Date")
                    ->sortable()
                    ->searchable(),
            ]);
    }
}
