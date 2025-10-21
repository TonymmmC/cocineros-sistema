<?php

namespace App\Filament\Resources\Pedidos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PedidosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('codigo_pedido')
                    ->label('Código')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('cliente.nombre_completo')
                    ->label('Cliente')
                    ->sortable()
                    ->searchable()
                    ->limit(20),

                TextColumn::make('cocinero.nombre_completo')
                    ->label('Cocinero')
                    ->sortable()
                    ->searchable()
                    ->limit(20),

                TextColumn::make('estado')
                    ->label('Estado')
                    ->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'pendiente' => 'Pendiente',
                            'confirmado' => 'Confirmado',
                            'preparando' => 'Preparando',
                            'listo' => 'Listo',
                            'en_camino' => 'En Camino',
                            'entregado' => 'Entregado',
                            'cancelado' => 'Cancelado',
                            default => ucfirst($state),
                        };
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendiente' => 'warning',
                        'confirmado' => 'info',
                        'preparando' => 'info',
                        'listo' => 'success',
                        'en_camino' => 'info',
                        'entregado' => 'success',
                        'cancelado' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('total')
                    ->label('Total')
                    ->money('BOB')
                    ->sortable(),

                TextColumn::make('metodo_pago')
                    ->label('Pago')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'qr' => 'QR',
                        'tarjeta' => 'Tarjeta',
                        'efectivo' => 'Efectivo',
                        default => ucfirst($state),
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'qr' => 'info',
                        'tarjeta' => 'success',
                        'efectivo' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('estado_pago')
                    ->label('Estado Pago')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pendiente' => 'Pendiente',
                        'pagado' => 'Pagado',
                        'reembolsado' => 'Reembolsado',
                        default => ucfirst($state),
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendiente' => 'warning',
                        'pagado' => 'success',
                        'reembolsado' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'confirmado' => 'Confirmado',
                        'preparando' => 'Preparando',
                        'listo' => 'Listo',
                        'en_camino' => 'En Camino',
                        'entregado' => 'Entregado',
                        'cancelado' => 'Cancelado',
                    ]),

                SelectFilter::make('metodo_pago')
                    ->label('Método de Pago')
                    ->options([
                        'qr' => 'QR',
                        'tarjeta' => 'Tarjeta',
                        'efectivo' => 'Efectivo',
                    ]),
            ])
            ->actions([
                // Actions can be added here
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
