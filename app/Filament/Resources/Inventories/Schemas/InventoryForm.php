<?php

namespace App\Filament\Resources\Inventories\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class InventoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'category')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('product')
                    ->label('Product')
                    ->required()
                    ->maxLength(255),

                TextInput::make('stock')
                    ->label('Stock')
                    ->numeric()
                    ->minValue(0)
                    ->required(),

                TextInput::make('price')
                    ->label('Purchase Price')
                    ->prefix('Rp')
                    ->required()
                    ->extraInputAttributes([
                        'x-on:input' => <<<'JS'
            $el.value = ($el.value || '')
                .toString()
                .replace(/\D/g, '')
                .replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        JS,
                        'inputmode' => 'numeric',
                    ])
                    ->rule(function () {
                        return function (string $attribute, $value, \Closure $fail) {
                            $num = preg_replace('/\D+/', '', (string) $value);

                            if ($num === '' || ! ctype_digit($num)) {
                                $fail('Purchase Price wajib diisi angka.');
                                return;
                            }

                            if ((int) $num < 0) {
                                $fail('Purchase Price minimal 0.');
                            }
                        };
                    })
                    ->dehydrateStateUsing(fn($state) => (int) preg_replace('/\D+/', '', (string) $state)),

                TextInput::make('selling_price')
                    ->label('Selling Price')
                    ->prefix('Rp')
                    ->required()
                    ->extraInputAttributes([
                        'x-on:input' => <<<'JS'
            $el.value = ($el.value || '')
                .toString()
                .replace(/\D/g, '')
                .replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        JS,
                        'inputmode' => 'numeric',
                    ])
                    ->rule(function () {
                        return function (string $attribute, $value, \Closure $fail) {
                            $num = preg_replace('/\D+/', '', (string) $value);

                            if ($num === '' || ! ctype_digit($num)) {
                                $fail('Selling Price wajib diisi angka.');
                                return;
                            }

                            if ((int) $num < 0) {
                                $fail('Selling Price minimal 0.');
                            }
                        };
                    })
                    ->dehydrateStateUsing(fn($state) => (int) preg_replace('/\D+/', '', (string) $state)),



            ]);
    }
}
