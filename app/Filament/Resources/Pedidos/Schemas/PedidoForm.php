<?php

namespace App\Filament\Resources\Pedidos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PedidoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Información del Pedido')
                    ->schema([
                        TextInput::make('codigo_pedido')
                            ->label('Código del Pedido')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20)
                            ->columnSpan(2),

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

                        Select::make('direccion_id')
                            ->label('Dirección de Entrega')
                            ->relationship('direccion', 'direccion')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(2),
                    ])
                    ->columns(2),

                Section::make('Estado y Montos')
                    ->schema([
                        Select::make('estado')
                            ->label('Estado del Pedido')
                            ->options([
                                'pendiente' => 'Pendiente',
                                'confirmado' => 'Confirmado',
                                'preparando' => 'Preparando',
                                'listo' => 'Listo',
                                'en_camino' => 'En Camino',
                                'entregado' => 'Entregado',
                                'cancelado' => 'Cancelado',
                            ])
                            ->required()
                            ->default('pendiente')
                            ->columnSpan(1),

                        TextInput::make('subtotal')
                            ->label('Subtotal (Bs.)')
                            ->required()
                            ->numeric()
                            ->prefix('Bs.')
                            ->columnSpan(1),

                        TextInput::make('comision_plataforma')
                            ->label('Comisión Plataforma (Bs.)')
                            ->numeric()
                            ->prefix('Bs.')
                            ->default(0)
                            ->columnSpan(1),

                        TextInput::make('costo_entrega')
                            ->label('Costo de Entrega (Bs.)')
                            ->numeric()
                            ->prefix('Bs.')
                            ->default(0)
                            ->columnSpan(1),

                        TextInput::make('total')
                            ->label('Total (Bs.)')
                            ->required()
                            ->numeric()
                            ->prefix('Bs.')
                            ->columnSpan(2),
                    ])
                    ->columns(2),

                Section::make('Pago y Tiempo')
                    ->schema([
                        Select::make('metodo_pago')
                            ->label('Método de Pago')
                            ->options([
                                'qr' => 'QR',
                                'tarjeta' => 'Tarjeta',
                                'efectivo' => 'Efectivo',
                            ])
                            ->required()
                            ->default('efectivo')
                            ->columnSpan(1),

                        Select::make('estado_pago')
                            ->label('Estado del Pago')
                            ->options([
                                'pendiente' => 'Pendiente',
                                'pagado' => 'Pagado',
                                'reembolsado' => 'Reembolsado',
                            ])
                            ->required()
                            ->default('pendiente')
                            ->columnSpan(1),

                        TextInput::make('tiempo_estimado_min')
                            ->label('Tiempo Estimado (min)')
                            ->numeric()
                            ->suffix('min')
                            ->columnSpan(2),

                        Textarea::make('notas_cliente')
                            ->label('Notas del Cliente')
                            ->rows(2)
                            ->maxLength(500)
                            ->columnSpan(2),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }
}
