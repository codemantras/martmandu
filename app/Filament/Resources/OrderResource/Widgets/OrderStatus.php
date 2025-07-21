<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStatus extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            $this->buildStat('Pending Orders', ['new', 'pending', 'processing'], 'warning', 'heroicon-o-arrow-path'),
            $this->buildStat('Shipped Orders', ['shipped'], 'primary', 'heroicon-o-truck'),
            $this->buildStat('Completed Orders', ['completed'], 'success', 'heroicon-o-check-circle'),
            $this->buildStat('Cancelled Orders', ['cancelled'], 'danger', 'heroicon-o-x-circle'),
        ];
    }

    protected function buildStat(string $label, array $statuses, string $color, string $icon = 'heroicon-o-shopping-cart'): Stat
    {
        $result = Order::whereIn('status', $statuses)
            ->selectRaw('count(*) as count, sum(grand_total) as total')
            ->first();

        $count = $result->count ?? 0;
        $total = number_format($result->total ?? 0, 2);

        return Stat::make($label, "Rs. {$total}")
            ->color($color)
            ->description("Total amount across {$count} order(s)")
            ->icon($icon);
    }

}
