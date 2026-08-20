<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Group::make()
                            ->schema([
                                Section::make('Product Information')
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (string $operation, $state, Set $set) {
                                                if ($operation !== 'create') {
                                                    return;
                                                }
                                                $set('slug', Str::slug($state));
                                            }),

                                        TextInput::make('slug')
                                            ->required()
                                            ->disabled()
                                            ->unique(Product::class, 'slug', ignoreRecord: true)
                                            ->dehydrated(),

                                        MarkdownEditor::make('description')
                                            ->columnSpanFull()
                                            ->fileAttachmentsDirectory('products'),
                                    ])
                                    ->columns(2),

                                Section::make('Images')
                                    ->schema([
                                        FileUpload::make('images')
                                            ->multiple()
                                            ->disk('public')
                                            ->directory('products')
                                            ->maxFiles(5)
                                            ->reorderable()
                                    ]),
                            ])
                            ->columnSpan(2),

                        Group::make()
                            ->schema([
                                Section::make('Price')
                                    ->schema([
                                        TextInput::make('price')
                                            ->required()
                                            ->numeric()
                                            ->suffix('AFN')
                                    ]),

                                Section::make('Accessories')
                                    ->schema([
                                        Select::make('category_id')
                                            ->relationship('category', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required(),

                                        Select::make('brand_id')
                                            ->relationship('brand', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                    ]),

                                Section::make('Status')
                                    ->schema([
                                        Toggle::make('in_stock')
                                            ->required()
                                            ->default(true),

                                        Toggle::make('is_active')
                                            ->required()
                                            ->default(true),

                                        Toggle::make('is_featured')
                                            ->required(),

                                        Toggle::make('on_sale')
                                            ->required(),
                                    ])
                            ])
                            ->columnSpan(1)

                    ])
                    ->columns(3)
            ])
            ->columns(1);
    }
}
