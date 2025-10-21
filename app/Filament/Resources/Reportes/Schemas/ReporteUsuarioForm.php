<?php

namespace App\Filament\Resources\Reportes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReporteUsuarioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Información del Reporte')
                    ->schema([
                        Select::make('reportador_id')
                            ->label('Usuario que Reporta')
                            ->relationship('reportador', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->helperText('Usuario que está realizando el reporte')
                            ->columnSpan(1),

                        Select::make('reportado_id')
                            ->label('Usuario Reportado')
                            ->relationship('reportado', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->helperText('Usuario que está siendo reportado')
                            ->columnSpan(1),

                        Select::make('pedido_id')
                            ->label('Pedido Relacionado')
                            ->relationship('pedido', 'codigo_pedido')
                            ->searchable()
                            ->preload()
                            ->helperText('Pedido relacionado con el reporte (opcional)')
                            ->columnSpan(2),

                        Select::make('motivo')
                            ->label('Motivo del Reporte')
                            ->options([
                                'comportamiento_inapropiado' => 'Comportamiento Inapropiado',
                                'producto_defectuoso' => 'Producto Defectuoso',
                                'entrega_tardía' => 'Entrega Tardía',
                                'falta_respeto' => 'Falta de Respeto',
                                'estafa' => 'Posible Estafa',
                                'contenido_inapropiado' => 'Contenido Inapropiado',
                                'spam' => 'Spam',
                                'otro' => 'Otro',
                            ])
                            ->required()
                            ->searchable()
                            ->columnSpan(2),

                        Textarea::make('descripcion')
                            ->label('Descripción Detallada')
                            ->required()
                            ->rows(4)
                            ->maxLength(1000)
                            ->helperText('Describe detalladamente el problema reportado')
                            ->columnSpan(2),
                    ])
                    ->columns(2),

                Section::make('Gestión del Reporte')
                    ->schema([
                        Select::make('estado')
                            ->label('Estado del Reporte')
                            ->options([
                                'pendiente' => 'Pendiente',
                                'en_revision' => 'En Revisión',
                                'resuelto' => 'Resuelto',
                                'rechazado' => 'Rechazado',
                            ])
                            ->required()
                            ->default('pendiente')
                            ->columnSpan(1),

                        Textarea::make('accion_tomada')
                            ->label('Acción Tomada')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Describe la acción tomada para resolver el reporte')
                            ->columnSpan(1),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }
}
