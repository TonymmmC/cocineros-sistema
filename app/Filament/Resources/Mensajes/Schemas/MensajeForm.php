<?php

namespace App\Filament\Resources\Mensajes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MensajeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Información del Mensaje')
                    ->schema([
                        Select::make('conversacion_id')
                            ->label('Conversación')
                            ->relationship('conversacion', 'id')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(1),

                        Select::make('remitente_id')
                            ->label('Remitente')
                            ->relationship('remitente', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(1),

                        Select::make('tipo')
                            ->label('Tipo de Mensaje')
                            ->options([
                                'texto' => 'Texto',
                                'imagen' => 'Imagen',
                                'sistema' => 'Sistema',
                            ])
                            ->required()
                            ->default('texto')
                            ->columnSpan(1),

                        Toggle::make('leido')
                            ->label('¿Leído?')
                            ->default(false)
                            ->columnSpan(1),

                        Textarea::make('mensaje')
                            ->label('Mensaje')
                            ->required()
                            ->rows(4)
                            ->maxLength(1000)
                            ->columnSpan(2),
                    ])
                    ->columns(2),
            ]);
    }
}
