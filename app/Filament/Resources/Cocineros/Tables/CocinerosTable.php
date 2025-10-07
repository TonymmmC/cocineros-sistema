<?php

namespace App\Filament\Resources\Cocineros\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CocinerosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto_perfil')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png'))
                    ->toggleable(),

                TextColumn::make('nombre_completo')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),

                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),

                TextColumn::make('ci')
                    ->label('CI')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('direccion')
                    ->label('Dirección')
                    ->limit(30)
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('radio_entrega_km')
                    ->label('Radio Entrega')
                    ->suffix(' km')
                    ->alignCenter()
                    ->toggleable(),

                TextColumn::make('calificacion_promedio')
                    ->label('Calificación')
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state >= 4.5 => 'success',
                        $state >= 3.5 => 'warning',
                        $state > 0 => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => $state > 0 ? number_format($state, 2) . ' ⭐' : 'Sin calificaciones')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('total_pedidos')
                    ->label('Pedidos')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(),

                TextColumn::make('productos_count')
                    ->label('Productos')
                    ->counts('productos')
                    ->badge()
                    ->color('info')
                    ->alignCenter()
                    ->toggleable(),

                IconColumn::make('esta_disponible')
                    ->label('Disponible')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Registrado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('esta_disponible')
                    ->label('Disponibilidad')
                    ->placeholder('Todos')
                    ->trueLabel('Disponibles')
                    ->falseLabel('No disponibles'),
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
            ->emptyStateHeading('No hay cocineros registrados')
            ->emptyStateDescription('Comienza registrando el primer cocinero.');
    }
}
