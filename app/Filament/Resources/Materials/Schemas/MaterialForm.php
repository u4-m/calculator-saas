<?php

namespace App\Filament\Resources\Materials\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),
                
                TextInput::make('price_per_kg')
                    ->label('Price per kg (USD)')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01)
                    ->columnSpan(1),
                
                TextInput::make('density')
                    ->label('Density (g/cm³)')
                    ->required()
                    ->numeric()
                    ->step(0.001)
                    ->suffix(' g/cm³')
                    ->columnSpan(1),
                
                TextInput::make('diameter')
                    ->label('Filament Diameter')
                    ->required()
                    ->numeric()
                    ->step(0.01)
                    ->suffix(' mm')
                    ->default(1.75)
                    ->columnSpan(1),
                
                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->columnSpan(1),
                
                Textarea::make('notes')
                    ->columnSpanFull()
                    ->maxLength(65535),
            ]);
    }
}
