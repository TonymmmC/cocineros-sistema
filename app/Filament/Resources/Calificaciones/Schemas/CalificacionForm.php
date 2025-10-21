<?php

namespace App\Filament\Resources\Calificaciones\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CalificacionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Información de la Calificación')
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

                        Select::make('pedido_id')
                            ->label('Pedido')
                            ->relationship('pedido', 'codigo_pedido')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(2),

                        TextInput::make('puntuacion')
                            ->label('Puntuación (1-5)')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(5)
                            ->step(1)
                            ->columnSpan(1),

                        Textarea::make('comentario')
                            ->label('Comentario')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpan(1),

                        Toggle::make('es_visible')
                            ->label('¿Visible?')
                            ->default(true)
                            ->columnSpan(2),
                    ])
                    ->columns(2),
            ]);
    }
}
