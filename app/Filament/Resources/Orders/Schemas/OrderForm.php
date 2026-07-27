<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Product;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Number;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                Select::make('user_id')
                                    ->label('Customers')
                                    ->relationship('user', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                Select::make('payment_method')
                                    ->options([
                                        'stripe' => 'Stripe',
                                        'cod' => 'Cash on Delivery',
                                    ])
                                    ->required(),
                                Select::make('payment_status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'paid' => 'Paid',
                                        'failed' => 'Failed',
                                    ])
                                    ->default('pending')
                                    ->required(),
                                ToggleButtons::make('status')
                                    ->inline()
                                    ->default('new')
                                    ->options([
                                        'new' => 'New',
                                        'processing' => 'Processing',
                                        'shipped' => 'Shipped',
                                        'delivered' => 'Delivered',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->colors([
                                        'new' => 'info',
                                        'processing' => 'warning',
                                        'shipped' => 'info',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger'
                                    ])
                                    ->icons([
                                        'new' => Heroicon::Sparkles,
                                        'processing' => Heroicon::ArrowPath,
                                        'shipped' => Heroicon::Truck,
                                        'delivered' => Heroicon::CheckCircle,
                                        'cancelled' => Heroicon::XCircle,
                                    ])
                                    ->required(),

                                Select::make('currency')
                                    ->options([
                                        'afn' => 'Afghan Afghani',
                                        'usd' => 'United States Dollar',
                                        'gbp' => 'British Pound Sterling',
                                    ])
                                    ->default('afn')
                                    ->required(),

                                Select::make('shipping_method')
                                    ->options([
                                        'fedex' => 'FedEx',
                                        'ups' => 'UPS',
                                    ]),

                                Textarea::make('notes')
                                    ->columnSpanFull()
                            ])
                            ->columns(2),

                        Section::make('Order Items')
                            ->schema([
                                Repeater::make('items')
                                    ->relationship('items')
                                    ->schema([
                                        Select::make('product_id')
                                            ->label('Product')
                                            ->relationship('product', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->distinct()
                                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                            ->reactive()
                                            ->afterStateUpdated(fn($state, Set $set) => $set('unit_amount', Product::find($state)?->price ?? 0))
                                            ->afterStateUpdated(fn($state, Set $set) => $set('total_amount', Product::find($state)?->price ?? 0))
                                            ->columnSpan(4),
                                        TextInput::make('quantity')
                                            ->numeric()
                                            ->required()
                                            ->default(1)
                                            ->minValue(1)
                                            ->columnspan(2)
                                            ->reactive()
                                            ->afterStateUpdated(fn($state, Set $set, Get $get) => $set('total_amount', $state * ($get('unit_amount') ?? 0))),
                                        TextInput::make('unit_amount')
                                            ->numeric()
                                            ->required()
                                            ->disabled()
                                            ->dehydrated()
                                            ->columnSpan(3),
                                        TextInput::make('total_amount')
                                            ->numeric()
                                            ->required()
                                            ->dehydrated()
                                            ->columnSpan(3)
                                    ])
                                    ->columns(12),

                                Placeholder::make('grand_total_placeholder')
                                    ->label('Grand Total')
                                    ->content(function (Get $get, Set $set) {
                                        $total = 0;
                                        if (!$repeaters = $get('items')) {
                                            return $total;
                                        }

                                        foreach ($repeaters as $key => $repeater) {
                                            $total += $get("items.{$key}.total_amount") ?? 0;
                                        }

                                        $set('grand_total', $total);

                                        return Number::currency($total, 'AFN');
                                    }),

                                Hidden::make('grand_total')
                                    ->default(0),
                            ])
                    ])
                    ->columnSpanFull()
            ]);
    }
}
