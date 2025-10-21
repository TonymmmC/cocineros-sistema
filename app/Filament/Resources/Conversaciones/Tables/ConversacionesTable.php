<?php

namespace App\Filament\Resources\Conversaciones\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ConversacionesTable
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

                TextColumn::make('mensajes_count')
                    ->label('Mensajes')
                    ->counts('mensajes')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Inicio')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('ultima_actividad')
                    ->label('Última Actividad')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                // Los filtros se pueden agregar aquí
            ])
            ->actions([
                // Actions can be added here
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('ultima_actividad', 'desc');
    }
}
