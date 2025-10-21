<?php

namespace App\Filament\Resources\Conversaciones\Schemas;

use Filament\Forms\Components\Select;
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
                        Select::make('pedido_id')
                            ->label('Pedido')
                            ->relationship('pedido', 'codigo_pedido')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(2),

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
                    ])
                    ->columns(2),
            ]);
    }
}
