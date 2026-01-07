<?php

namespace App\Filament\Resources\Channels\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class ChannelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                TextInput::make('name')
                    ->label('Channel Name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
            ]);
    }
}
