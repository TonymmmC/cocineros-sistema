<?php

namespace App\Filament\Widgets;

use App\Models\Cocinero;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopCocinerosWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Cocinero::query()
                    ->with('user')
                    ->withCount('pedidos')
                    ->where('esta_disponible', true)
                    ->orderBy('calificacion_promedio', 'desc')
                    ->limit(10)
            )
            ->heading('Top 10 Cocineros')
            ->columns([
                TextColumn::make('nombre_completo')
                    ->label('Cocinero')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->limit(30),

                TextColumn::make('direccion')
                    ->label('Dirección')
                    ->searchable()
                    ->limit(40),

                TextColumn::make('calificacion_promedio')
                    ->label('Calificación')
                    ->badge()
                    ->color(fn ($state) => match(true) {
                        !$state => 'gray',
                        $state < 2.5 => 'danger',
                        $state < 3.5 => 'warning',
                        default => 'success',
                    })
                    ->formatStateUsing(function ($state) {
                        if (!$state) return 'Sin calificaciones';
                        return number_format($state, 1) . '/5';
                    })
                    ->icon('heroicon-m-star')
                    ->sortable(),

                TextColumn::make('pedidos_count')
                    ->label('Total Pedidos')
                    ->badge()
                    ->color('success')
                    ->sortable(),

                TextColumn::make('esta_disponible')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Disponible' : 'No Disponible')
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
            ])
            ->defaultSort('calificacion_promedio', 'desc');
    }
}
