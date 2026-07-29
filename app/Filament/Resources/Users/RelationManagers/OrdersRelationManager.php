<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('order_id')
            ->columns([
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
                TextColumn::make('created_at')
                    ->label('Order Date')
                    ->dateTime()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                Action::make('View Orders')
                    ->url(fn(Order $record): string => OrderResource::getUrl('view', ['record' => $record]))
                    ->color('primary')
                    ->icon(Heroicon::Eye),
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
