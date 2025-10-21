<?php

namespace App\Filament\Resources\Conversaciones\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ConversacionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Información de la Conversación')
                    ->schema([
                        Select::make('cliente_id')
                            ->label('Cliente')
                            ->relationship('cliente', 'nombre_completo')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(1),

                        Select::make('cocinero_id')
                            ->label('Cocinero')
                            ->relationship('cocinero', 'nombre_completo')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(1),

                        Toggle::make('activa')
                            ->label('¿Activa?')
                            ->default(true)
                            ->columnSpan(2),
                    ])
                    ->columns(2),
            ]);
    }
}
