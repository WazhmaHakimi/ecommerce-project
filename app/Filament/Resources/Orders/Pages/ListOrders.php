<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Enums\OrderStatus;
use App\Filament\Resources\Orders\OrderResource;
use App\Filament\Resources\Orders\Widgets\OrderStats;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OrderStats::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            OrderStatus::New->value => Tab::make('New')->query(fn($query) => $query->where('status', OrderStatus::New->value)),
            OrderStatus::Processing->value => Tab::make('Processing')->query(fn($query) => $query->where('status', OrderStatus::Processing->value)),
            OrderStatus::Shipped->value => Tab::make('Shipped')->query(fn($query) => $query->where('status', OrderStatus::Shipped->value)),
            OrderStatus::Delivered->value => Tab::make('Delivered')->query(fn($query) => $query->where('status', OrderStatus::Delivered->value)),
            OrderStatus::Cancelled->value => Tab::make('Cancelled')->query(fn($query) => $query->where('status', OrderStatus::Cancelled->value)),
        ];
    }
}
