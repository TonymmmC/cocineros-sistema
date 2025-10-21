<?php

namespace App\Filament\Resources\Transacciones\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TransaccionesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('codigo_transaccion')
                    ->label('Código')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('pedido.codigo_pedido')
                    ->label('Pedido')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('monto')
                    ->label('Monto')
                    ->money('BOB')
                    ->sortable(),

                TextColumn::make('metodo_pago')
                    ->label('Método')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'qr' => 'QR',
                        'tarjeta' => 'Tarjeta',
                        'efectivo' => 'Efectivo',
                        'transferencia' => 'Transferencia',
                        default => ucfirst($state),
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'qr' => 'info',
                        'tarjeta' => 'success',
                        'efectivo' => 'warning',
                        'transferencia' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('estado')
                    ->label('Estado')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pendiente' => 'Pendiente',
                        'procesando' => 'Procesando',
                        'completada' => 'Completada',
                        'fallida' => 'Fallida',
                        'reembolsada' => 'Reembolsada',
                        default => ucfirst($state),
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendiente' => 'warning',
                        'procesando' => 'info',
                        'completada' => 'success',
                        'fallida' => 'danger',
                        'reembolsada' => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('referencia_pago')
                    ->label('Referencia')
                    ->limit(20)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 20 ? $state : null;
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
                        'procesando' => 'Procesando',
                        'completada' => 'Completada',
                        'fallida' => 'Fallida',
                        'reembolsada' => 'Reembolsada',
                    ]),

                SelectFilter::make('metodo_pago')
                    ->label('Método de Pago')
                    ->options([
                        'qr' => 'QR',
                        'tarjeta' => 'Tarjeta',
                        'efectivo' => 'Efectivo',
                        'transferencia' => 'Transferencia',
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
