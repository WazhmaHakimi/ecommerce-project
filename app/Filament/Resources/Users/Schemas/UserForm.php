<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Section;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()
                ->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('email')->label('Email address')->email()->required(),
                    DateTimePicker::make('email_verified_at')->default(now()),
                    TextInput::make('password')
                        ->password()
                        ->required(function ($livewire) {
                            return $livewire instanceof CreateUser;
                        })
                        ->dehydrated(fn($state) => filled($state)),
                ])
                ->columns(2),
        ])
        ->columns(1);
    }
}
