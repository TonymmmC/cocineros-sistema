<?php

namespace App\Filament\Resources\Transacciones\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TransaccionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Información de la Transacción')
                    ->schema([
                        TextInput::make('codigo_transaccion')
                            ->label('Código de Transacción')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->columnSpan(2),

                        Select::make('pedido_id')
                            ->label('Pedido')
                            ->relationship('pedido', 'codigo_pedido')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(1),

                        Select::make('metodo_pago')
                            ->label('Método de Pago')
                            ->options([
                                'qr' => 'QR',
                                'tarjeta' => 'Tarjeta',
                                'efectivo' => 'Efectivo',
                                'transferencia' => 'Transferencia',
                            ])
                            ->required()
                            ->columnSpan(1),

                        TextInput::make('monto')
                            ->label('Monto (Bs.)')
                            ->required()
                            ->numeric()
                            ->prefix('Bs.')
                            ->columnSpan(1),

                        Select::make('estado')
                            ->label('Estado')
                            ->options([
                                'pendiente' => 'Pendiente',
                                'procesando' => 'Procesando',
                                'completada' => 'Completada',
                                'fallida' => 'Fallida',
                                'reembolsada' => 'Reembolsada',
                            ])
                            ->required()
                            ->default('pendiente')
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Section::make('Detalles del Pago')
                    ->schema([
                        TextInput::make('referencia_pago')
                            ->label('Referencia de Pago')
                            ->maxLength(100)
                            ->columnSpan(1),

                        TextInput::make('comision_plataforma')
                            ->label('Comisión Plataforma (Bs.)')
                            ->numeric()
                            ->prefix('Bs.')
                            ->default(0)
                            ->columnSpan(1),

                        Textarea::make('notas')
                            ->label('Notas')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpan(2),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }
}
