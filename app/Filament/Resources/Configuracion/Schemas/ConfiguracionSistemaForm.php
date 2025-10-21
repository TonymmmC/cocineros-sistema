<?php

namespace App\Filament\Resources\Configuracion\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ConfiguracionSistemaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Configuración del Sistema')
                    ->schema([
                        TextInput::make('clave')
                            ->label('Clave')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(100)
                            ->columnSpan(2),

                        Select::make('tipo')
                            ->label('Tipo de Valor')
                            ->options([
                                'string' => 'Texto',
                                'number' => 'Número',
                                'boolean' => 'Verdadero/Falso',
                                'json' => 'JSON',
                            ])
                            ->required()
                            ->default('string')
                            ->columnSpan(1),

                        Toggle::make('es_publica')
                            ->label('¿Es Pública?')
                            ->default(false)
                            ->helperText('Las configuraciones públicas son accesibles desde la API')
                            ->columnSpan(1),

                        TextInput::make('valor')
                            ->label('Valor')
                            ->required()
                            ->columnSpan(2),

                        Textarea::make('descripcion')
                            ->label('Descripción')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpan(2),
                    ])
                    ->columns(2),
            ]);
    }
}
