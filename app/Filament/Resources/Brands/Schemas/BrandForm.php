<?php

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;
use Filament\Schemas\Components\Utilities\Set;
use App\Models\Category;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->live()
                            ->afterStateUpdated(
                                fn (string $operation, $state, Set $set) => $operation === 'create'
                                    ? $set('slug', Str::slug($state))
                                    : null
                            ),
                        TextInput::make('slug')
                            ->required()
                            ->unique(Category::class, 'slug', ignoreRecord: true)
                            ->disabled()
                            ->dehydrated(),
                        FileUpload::make('image')
                            ->image()
                            ->directory('categories')
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->required()
                            ->default(true),
                    ])
                    ->columns(2),
            ])
            ->columns(1);
    }
}
