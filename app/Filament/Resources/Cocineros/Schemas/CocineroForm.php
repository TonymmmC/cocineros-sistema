<?php

namespace App\Filament\Resources\Cocineros\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class CocineroForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make('Información del Cocinero')
                    ->tabs([
                        Tabs\Tab::make('Datos Personales')
                            ->schema([
                                Select::make('user_id')
                                    ->label('Usuario Asociado')
                                    ->relationship('user', 'name', function ($query, $record) {
                                        // Solo usuarios con rol 'cocinero' que No tengan perfil de cocinero
                                        $query->where('role', 'cocinero')
                                            ->whereDoesntHave('cocinero');

                                        // Si estamos EDITANDO, permitir el usuario actual
                                        if ($record && $record->user_id) {
                                            $query->orWhere('id', $record->user_id);
                                        }

                                        return $query;
                                    })
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->helperText('Selecciona el usuario que será asociado a este perfil de cocinero')
                                    ->columnSpan(2),

                                TextInput::make('nombre_completo')
                                    ->label('Nombre Completo')
                                    ->required()
                                    ->maxLength(35)
                                    ->regex('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+(\s+[a-zA-ZáéíóúÁÉÍÓÚñÑ]+)+$/')
                                    ->validationMessages([
                                        'regex' => 'Debe ingresar al menos nombre y apellido (solo letras y espacios)',
                                    ])
                                    ->helperText('Ejemplo: Juan Perez Lopez')
                                    ->columnSpan(1),

                                TextInput::make('ci')
                                    ->label('Cédula de Identidad')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->numeric()
                                    ->rules([
                                        'digits_between:5,8',
                                    ])
                                    ->validationMessages([
                                        'numeric' => 'La CI solo puede contener números.',
                                        'digits_between' => 'La C.I. debe tener entre 5 y 8 dígitos.',
                                        'unique' => 'Esta Cédula de Identidad ya está registrada.',
                                    ])
                                    ->columnSpan(1),

                                FileUpload::make('foto_perfil')
                                    ->label('Foto de Perfil')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('cocineros/fotos')
                                    ->visibility('public')
                                    ->columnSpan(2),

                                Textarea::make('bio')
                                    ->label('Biografía')
                                    ->rows(3)
                                    ->maxLength(300)
                                    ->columnSpan(2),
                            ])
                            ->columns(2),

                        Tabs\Tab::make('Ubicación')
                            ->schema([
                                Textarea::make('direccion')
                                    ->label('Dirección Completa')
                                    ->required()
                                    ->validationMessages([
                                        'required' => 'La Dirección es necesaria.'
                                        ])
                                    ->rows(2)
                                    ->columnSpan(2),

                                TextInput::make('latitud')
                                    ->label('Latitud')
                                    ->numeric()
                                    ->step(0.00000001)
                                    ->helperText('Coordenada de ubicación')
                                    ->columnSpan(1),

                                TextInput::make('longitud')
                                    ->label('Longitud')
                                    ->numeric()
                                    ->step(0.00000001)
                                    ->helperText('Coordenada de ubicación')
                                    ->columnSpan(1),

                                TextInput::make('radio_entrega_km')
                                    ->label('Radio de Entrega (km)')
                                    ->required()
                                    ->numeric()
                                    ->default(5.00)
                                    ->minValue(0.5)
                                    ->maxValue(50)
                                    ->step(0.5)
                                    ->suffix('km')
                                    ->columnSpan(2),
                            ])
                            ->columns(2),

                        Tabs\Tab::make('Especialidades')
                            ->schema([
                                Repeater::make('especialidades')
                                    ->label('Especialidades Culinarias')
                                    ->simple(
                                        TextInput::make('especialidad')
                                            ->label('Especialidad')
                                            ->required()
                                            ->placeholder('Ej: Comida Tradicional Boliviana')
                                    )
                                    ->defaultItems(1)
                                    ->columnSpan(2),

                                Repeater::make('certificaciones')
                                    ->label('Certificaciones')
                                    ->simple(
                                        TextInput::make('certificacion')
                                            ->label('Certificación')
                                            ->placeholder('Ej: Manipulación de Alimentos')
                                    )
                                    ->defaultItems(0)
                                    ->columnSpan(2),
                            ])
                            ->columns(2),
                    ]),

                Section::make('Estado y Estadísticas')
                    ->schema([
                        Toggle::make('esta_disponible')
                            ->label('¿Disponible para recibir pedidos?')
                            ->default(true)
                            ->inline(false)
                            ->columnSpan(2),

                        TextInput::make('calificacion_promedio')
                            ->label('Calificación Promedio')
                            ->numeric()
                            ->disabled()
                            ->default(0.00)
                            ->suffix('/ 5')
                            ->columnSpan(1),

                        TextInput::make('total_pedidos')
                            ->label('Total de Pedidos')
                            ->numeric()
                            ->disabled()
                            ->default(0)
                            ->columnSpan(1),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }
}
