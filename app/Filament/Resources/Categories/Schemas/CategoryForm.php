<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class CategoryForm
{


    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                TextInput::make('category')
                    ->label('Category')
                    ->required()
                    ->maxLength(255),

                TextInput::make('min_stock')
                    ->label('Min Stock')
                    ->numeric()
                    ->minValue(0)
                    ->required(),

                TextInput::make('max_stock')
                    ->label('Max Stock')
                    ->numeric()
                    ->minValue(0)
                    ->required(),
            ]);
    }
}
