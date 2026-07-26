<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Product Details')
                    ->schema([
                        TextEntry::make('category.name')
                            ->label('Category')
                            ->placeholder('-'),
                        TextEntry::make('brand.name')
                            ->label('Brand')
                            ->placeholder('-'),
                        TextEntry::make('name'),
                        TextEntry::make('slug'),
                        TextEntry::make('description')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('price')
                            ->money('AFN', true)
                            ->columnSpanFull(),
                        IconEntry::make('is_active')
                            ->boolean(),
                        IconEntry::make('is_featured')
                            ->boolean(),
                        IconEntry::make('in_stock')
                            ->boolean(),
                        IconEntry::make('on_sale')
                            ->boolean(),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ])
                    ->columns(2),

                Section::make('Product Images')
                    ->schema([
                        ImageEntry::make('images')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ])
            ])
            ->columns(1);
    }
}
