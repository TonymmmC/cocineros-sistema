<?php

namespace App\Filament\Widgets;

use App\Models\Pedido;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOrdersWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Pedido::query()
                    ->with(['cliente', 'cocinero'])
                    ->latest()
                    ->limit(10)
            )
            ->heading('Pedidos Recientes')
            ->columns([
                TextColumn::make('codigo_pedido')
                    ->label('Código')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('cliente.nombre_completo')
                    ->label('Cliente')
                    ->searchable()
                    ->limit(20),

                TextColumn::make('cocinero.nombre_completo')
                    ->label('Cocinero')
                    ->searchable()
                    ->limit(20),

                TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendiente' => 'warning',
                        'confirmado' => 'info',
                        'en_preparacion' => 'primary',
                        'listo' => 'success',
                        'en_camino' => 'success',
                        'entregado' => 'success',
                        'cancelado' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pendiente' => 'Pendiente',
                        'confirmado' => 'Confirmado',
                        'en_preparacion' => 'En Preparación',
                        'listo' => 'Listo',
                        'en_camino' => 'En Camino',
                        'entregado' => 'Entregado',
                        'cancelado' => 'Cancelado',
                        default => $state,
                    }),

                TextColumn::make('total')
                    ->label('Total')
                    ->money('USD')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
