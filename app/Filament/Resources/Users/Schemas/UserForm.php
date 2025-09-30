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
                    ->columnSpan(1),

                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->columnSpan(1),

                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required(fn ($operation) => $operation === 'create')
                    ->minLength(8)
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                    ->dehydrated(fn ($state) => filled($state))
                    ->helperText('Dejar vacío para mantener la contraseña actual')
                    ->columnSpan(1),

                Select::make('role')
                    ->label('Rol')
                    ->options([
                        'superadmin' => 'Super Administrador',
                        'admin' => 'Administrador',
                        'cocinero' => 'Cocinero',
                        'cliente' => 'Cliente',
                    ])
                    ->required()
                    ->default('cliente')
                    ->columnSpan(1),

                TextInput::make('phone')
                    ->label('Teléfono')
                    ->tel()
                    ->maxLength(20)
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
