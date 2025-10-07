<?php

namespace App\Filament\Resources\Productos\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Información Básica')
                    ->schema([
                        TextInput::make('nombre')
                            ->label('Nombre del Producto')
                            ->required()
                            ->maxLength(150)
                            ->columnSpan(2),

                        Textarea::make('descripcion')
                            ->label('Descripción')
                            ->required()
                            ->rows(3)
                            ->columnSpan(2),

                        Select::make('categoria_id')
                            ->label('Categoría')
                            ->relationship('categoria', 'nombre')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(1),

                        Select::make('cocinero_id')
                            ->label('Cocinero')
                            ->relationship('cocinero', 'name')
                            ->searchable()
                            ->preload()
                            ->columnSpan(1),

                        TextInput::make('precio')
                            ->label('Precio (Bs.)')
                            ->required()
                            ->numeric()
                            ->prefix('Bs.')
                            ->minValue(0)
                            ->step(0.5)
                            ->columnSpan(1),

                        TextInput::make('tiempo_preparacion_min')
                            ->label('Tiempo de Preparación (minutos)')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->suffix('min')
                            ->default(30)
                            ->columnSpan(1),

                        TextInput::make('porciones')
                            ->label('Porciones')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->default(1)
                            ->columnSpan(1),

                        TextInput::make('stock_disponible')
                            ->label('Stock Disponible')
                            ->numeric()
                            ->minValue(0)
                            ->helperText('Dejar vacío para stock ilimitado')
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Section::make('Ingredientes y Alérgenos')
                    ->schema([
                        Repeater::make('ingredientes')
                            ->label('Ingredientes')
                            ->simple(
                                TextInput::make('ingrediente')
                                    ->label('Ingrediente')
                                    ->required()
                            )
                            ->defaultItems(0)
                            ->columnSpan(1),

                        Repeater::make('alergenos')
                            ->label('Alérgenos')
                            ->simple(
                                TextInput::make('alergeno')
                                    ->label('Alérgeno')
                                    ->required()
                            )
                            ->defaultItems(0)
                            ->columnSpan(1),
                    ])
                    ->columns(2)
                    ->collapsed(),

                Section::make('Características Dietéticas')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Toggle::make('es_vegetariano')
                                    ->label('Vegetariano')
                                    ->inline(false),

                                Toggle::make('es_vegano')
                                    ->label('Vegano')
                                    ->inline(false),

                                Toggle::make('es_sin_gluten')
                                    ->label('Sin Gluten')
                                    ->inline(false),
                            ]),
                    ])
                    ->collapsed(),

                Section::make('Disponibilidad')
                    ->schema([
                        Toggle::make('disponible')
                            ->label('¿Producto Disponible?')
                            ->default(true)
                            ->helperText('Los productos no disponibles no se mostrarán en la plataforma')
                            ->inline(false),
                    ]),
            ]);
    }
}
