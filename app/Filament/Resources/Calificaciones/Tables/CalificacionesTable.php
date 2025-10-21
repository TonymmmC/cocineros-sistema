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

                IconColumn::make('puntuacion')
                    ->label('Puntuación')
                    ->formatStateUsing(function ($state) {
                        return str_repeat('⭐', $state);
                    })
                    ->sortable(),

                TextColumn::make('comentario')
                    ->label('Comentario')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),

                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('puntuacion')
                    ->label('Puntuación')
                    ->options([
                        1 => '1 ⭐',
                        2 => '2 ⭐⭐',
                        3 => '3 ⭐⭐⭐',
                        4 => '4 ⭐⭐⭐⭐',
                        5 => '5 ⭐⭐⭐⭐⭐',
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
