<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order Information')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Customer'),
                        TextEntry::make('grand_total')
                            ->numeric()
                            ->placeholder('-'),
                        TextEntry::make('payment_method')
                            ->placeholder('-'),
                        TextEntry::make('payment_status')
                            ->label('Payment Status')
                            ->badge(fn(PaymentStatus $state) => $state->getColor())
                            ->icon(fn(PaymentStatus $state) => $state->getIcon()),
                        TextEntry::make('status')
                            ->label('Order Status')
                            ->badge(fn(OrderStatus $state) => $state->getColor())
                            ->icon(fn(OrderStatus $state) => $state->getIcon()),
                        TextEntry::make('currency')
                            ->placeholder('-'),
                        TextEntry::make('shipping_amount')
                            ->numeric()
                            ->placeholder('-'),
                        TextEntry::make('shipping_method')
                            ->placeholder('-'),
                        TextEntry::make('notes')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ])
                    ->columns(2),
            ])
            ->columns(1);
    }
}
