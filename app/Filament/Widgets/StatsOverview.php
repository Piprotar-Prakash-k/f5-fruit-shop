<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalSales = Order::join('products', 'orders.product_id', '=', 'products.id')
            ->selectRaw('SUM(orders.quantity * products.price) as total')
            ->value('total') ?? 0;

        return [
            Stat::make('Total Products', Product::count())
                ->icon('heroicon-o-shopping-bag')
                ->color('primary'),

            Stat::make('Total Orders', Order::count())
                ->icon('heroicon-o-clipboard-document-list')
                ->color('warning'),

            Stat::make('Total Sales', '₹' . number_format($totalSales, 2))
                ->icon('heroicon-o-currency-rupee')
                ->color('success'),
        ];
    }
}
