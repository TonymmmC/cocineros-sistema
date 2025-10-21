<?php

namespace App\Filament\Resources\Calificaciones\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CalificacionesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

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

                TextColumn::make('pedido.codigo_pedido')
                    ->label('Pedido')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('puntuacion')
                    ->label('Puntuación')
                    ->badge()
                    ->color(fn ($state) => match((int) $state) {
                        1, 2 => 'danger',
                        3 => 'warning',
                        4 => 'success',
                        5 => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => $state . '/5')
                    ->icon('heroicon-m-star')
                    ->sortable(),

                TextColumn::make('comentario')
                    ->label('Comentario')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),

                IconColumn::make('es_visible')
                    ->label('Visible')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('puntuacion')
                    ->label('Puntuación')
                    ->options([
                        1 => '1 estrella',
                        2 => '2 estrellas',
                        3 => '3 estrellas',
                        4 => '4 estrellas',
                        5 => '5 estrellas',
                    ]),

                SelectFilter::make('es_visible')
                    ->label('Visibilidad')
                    ->options([
                        true => 'Visible',
                        false => 'Oculta',
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
