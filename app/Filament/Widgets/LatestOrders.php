<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestOrders extends TableWidget
{
    protected string|array|int $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => Order::query())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('grand_total')
                    ->money('AFN')
                    ->placeholder('-'),
                TextColumn::make('payment_status')
                    ->placeholder('-')
                    ->badge(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'new' => 'info',
                        'processing' => 'info',
                        'shipped' => 'success',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                    })
                    ->icon(fn(string $state): Heroicon => match ($state) {
                        'new' => Heroicon::Sparkles,
                        'processing' => Heroicon::ArrowPath,
                        'shipped' => Heroicon::Truck,
                        'delivered' => Heroicon::CheckCircle,
                        'cancelled' => Heroicon::XCircle,
                    })
                    ->sortable()
                    ->searchable(),
                TextColumn::make('payment_method')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('payment_status')
                    ->sortable()
                    ->badge(),
                TextColumn::make('created_at')
                    ->label('Order Date')
                    ->dateTime()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                Action::make('View Order')
                    ->url(fn(Order $record): string => OrderResource::getUrl('view', ['record' => $record]))

                    ->icon(Heroicon::Eye),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
