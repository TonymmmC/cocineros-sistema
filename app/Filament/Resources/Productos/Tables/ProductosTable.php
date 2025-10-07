<?php

namespace App\Filament\Resources\Productos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Producto')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap()
                    ->limit(30),

                TextColumn::make('categoria.nombre')
                    ->label('Categoría')
                    ->badge()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('cocinero.name')
                    ->label('Cocinero')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('precio')
                    ->label('Precio')
                    ->money('BOB')
                    ->sortable()
                    ->alignEnd(),

                TextColumn::make('tiempo_preparacion_min')
                    ->label('Tiempo')
                    ->suffix(' min')
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('porciones')
                    ->label('Porciones')
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('stock_disponible')
                    ->label('Stock')
                    ->placeholder('∞')
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('es_vegetariano')
                    ->label('VEG')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-mark')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->alignCenter()
                    ->tooltip(fn ($state) => $state ? 'Vegetariano' : 'No vegetariano')
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('es_vegano')
                    ->label('VGN')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-mark')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->alignCenter()
                    ->tooltip(fn ($state) => $state ? 'Vegano' : 'No vegano')
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('es_sin_gluten')
                    ->label('S/G')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-mark')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->alignCenter()
                    ->tooltip(fn ($state) => $state ? 'Sin gluten' : 'Contiene gluten')
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('disponible')
                    ->label('Disponible')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('vistas')
                    ->label('Vistas')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('categoria_id')
                    ->label('Categoría')
                    ->relationship('categoria', 'nombre')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('cocinero_id')
                    ->label('Cocinero')
                    ->relationship('cocinero', 'name')
                    ->searchable()
                    ->preload(),

                TernaryFilter::make('disponible')
                    ->label('Disponibilidad')
                    ->placeholder('Todos')
                    ->trueLabel('Disponibles')
                    ->falseLabel('No disponibles'),

                TernaryFilter::make('es_vegetariano')
                    ->label('Vegetariano')
                    ->placeholder('Todos')
                    ->trueLabel('Sí')
                    ->falseLabel('No'),

                TernaryFilter::make('es_vegano')
                    ->label('Vegano')
                    ->placeholder('Todos')
                    ->trueLabel('Sí')
                    ->falseLabel('No'),

                TernaryFilter::make('es_sin_gluten')
                    ->label('Sin Gluten')
                    ->placeholder('Todos')
                    ->trueLabel('Sí')
                    ->falseLabel('No'),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Editar'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Eliminar seleccionados'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('No hay productos')
            ->emptyStateDescription('Comienza creando tu primer producto gastronómico.');
    }
}
