<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OderStatus extends BaseWidget
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
        $count = Order::whereIn('status', $statuses)->count();
        $total = number_format(Order::whereIn('status', $statuses)->sum('grand_total'), 2);

        return Stat::make($label, "Rs. {$total}")
            ->color($color)
            ->description("Total amount across {$count} order(s)")
            ->icon($icon);
    }

}
