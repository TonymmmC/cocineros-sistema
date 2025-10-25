<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->schema([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255)
                    ->regex('/^[a-zA-Z-áéíóúÁÉÍÓÚñÑ\s]+$/')
                    ->validationMessages([
                        'regex' => 'El nombre solo puede contener letras',
                    ])
                    ->columnSpan(1),

                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->suffix('@gmail.com')
                    ->dehydrateStateUsing(fn ($state) => $state . '@gmail.com')
                    ->formatStateUsing(fn ($state) => str_replace('@gmail.com', '',$state))
                    ->columnSpan(1),

                Select::make('role')
                    ->label('Rol')
                    ->options([
                        'admin' => 'Administrador',
                        'cocinero' => 'Cocinero',
                        'cliente' => 'Cliente',
                    ])
                    ->required()
                    ->default('cliente')
                    ->native(false)
                    ->columnSpan(1),

                TextInput::make('phone')
                    ->label('Teléfono')
                    ->tel()
                    ->maxLength(8)
                    ->minLength(8)
                    ->numeric()
                    ->validationMessages([
                        'numeric' => 'El teléfono solo puede contener números.',
                        'min' => 'El teléfono debe tener exactamente 8 dígitos.',
                        'max' => 'El teléfono deber tener exactamente 8 dígitos',
                    ])
                    ->columnSpan(1),

                Toggle::make('is_verified')
                    ->label('¿Verificado?')
                    ->default(true)
                    ->helperText('Usuario ha verificado su cuenta')
                    ->columnSpan(1),

                Toggle::make('is_active')
                    ->label('¿Activo?')
                    ->default(true)
                    ->helperText('Usuario puede acceder al sistema')
                    ->columnSpan(1),
            ]);
    }
}
