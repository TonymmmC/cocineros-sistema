<?php

namespace App\Filament\Resources\Clientes\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ClienteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Información del Cliente')
                    ->schema([
                        Select::make('user_id')
                            ->label('Usuario Asociado')
                            ->relationship('user', 'name', function ($query) {
                                return $query->where('role', 'cliente');
                            })
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(2),

                        TextInput::make('nombre_completo')
                            ->label('Nombre Completo')
                            ->required()
                            ->maxLength(150)
                            ->columnSpan(2),

                        FileUpload::make('foto_perfil')
                            ->label('Foto de Perfil')
                            ->image()
                            ->imageEditor()
                            ->directory('clientes/fotos')
                            ->visibility('public')
                            ->columnSpan(2),
                    ])
                    ->columns(2),

                Section::make('Preferencias Alimentarias')
                    ->schema([
                        Repeater::make('preferencias_alimentarias')
                            ->label('Preferencias')
                            ->simple(
                                TextInput::make('preferencia')
                                    ->label('Preferencia')
                                    ->required()
                                    ->placeholder('Ej: Sin gluten, Vegetariano')
                            )
                            ->defaultItems(0)
                            ->columnSpan(2),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }
}
