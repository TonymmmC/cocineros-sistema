<?php

namespace App\Filament\Resources\Categorias\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoriaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Información Básica')
                    ->schema([
                        TextInput::make('nombre')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(100)
                            ->unique(ignoreRecord: true)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                            ->columnSpan(1),

                        TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->maxLength(120)
                            ->unique(ignoreRecord: true)
                            ->helperText('Se genera automáticamente desde el nombre')
                            ->disabled()
                            ->dehydrated()
                            ->columnSpan(1),

                        Select::make('icono')
                            ->label('Icono')
                            ->options([
                                'cake' => 'Pastel (Tradicional)',
                                'globe-alt' => 'Globo (Internacional)',
                                'sparkles' => 'Destellos (Vegana)',
                                'leaf' => 'Hoja (Vegetariana)',
                                'gift' => 'Regalo (Postres)',
                                'beaker' => 'Vaso (Bebidas)',
                                'bolt' => 'Rayo (Rápida)',
                                'heart' => 'Corazón (Saludable)',
                                'fire' => 'Fuego',
                                'star' => 'Estrella',
                            ])
                            ->searchable()
                            ->helperText('Selecciona un icono Heroicon')
                            ->columnSpan(1),

                        TextInput::make('orden')
                            ->label('Orden')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->maxValue(255)
                            ->helperText('Define el orden de visualización (menor número = mayor prioridad)')
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Section::make('Configuración')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('¿Activa?')
                            ->default(true)
                            ->helperText('Las categorías inactivas no se mostrarán en la plataforma')
                            ->inline(false),
                    ]),
            ]);
    }
}
