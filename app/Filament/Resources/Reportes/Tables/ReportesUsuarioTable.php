<?php

namespace App\Filament\Resources\Reportes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReportesUsuarioTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('reportador.name')
                    ->label('Reportador')
                    ->sortable()
                    ->searchable()
                    ->limit(20),

                TextColumn::make('reportado.name')
                    ->label('Usuario Reportado')
                    ->sortable()
                    ->searchable()
                    ->limit(20),

                TextColumn::make('motivo')
                    ->label('Motivo')
                    ->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'comportamiento_inapropiado' => 'Comportamiento Inapropiado',
                            'producto_defectuoso' => 'Producto Defectuoso',
                            'entrega_tardía' => 'Entrega Tardía',
                            'falta_respeto' => 'Falta de Respeto',
                            'estafa' => 'Posible Estafa',
                            'contenido_inapropiado' => 'Contenido Inapropiado',
                            'spam' => 'Spam',
                            'otro' => 'Otro',
                            default => ucfirst(str_replace('_', ' ', $state)),
                        };
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'comportamiento_inapropiado' => 'danger',
                        'estafa' => 'danger',
                        'producto_defectuoso' => 'warning',
                        'entrega_tardía' => 'warning',
                        'falta_respeto' => 'warning',
                        'contenido_inapropiado' => 'warning',
                        'spam' => 'info',
                        'otro' => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('estado')
                    ->label('Estado')
                    ->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'pendiente' => 'Pendiente',
                            'en_revision' => 'En Revisión',
                            'resuelto' => 'Resuelto',
                            'rechazado' => 'Rechazado',
                            default => ucfirst($state),
                        };
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendiente' => 'warning',
                        'en_revision' => 'info',
                        'resuelto' => 'success',
                        'rechazado' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('pedido.codigo_pedido')
                    ->label('Pedido')
                    ->sortable()
                    ->searchable()
                    ->placeholder('Sin pedido'),

                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),

                TextColumn::make('created_at')
                    ->label('Fecha de Reporte')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label('Última Actualización')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'en_revision' => 'En Revisión',
                        'resuelto' => 'Resuelto',
                        'rechazado' => 'Rechazado',
                    ]),

                SelectFilter::make('motivo')
                    ->label('Motivo')
                    ->options([
                        'comportamiento_inapropiado' => 'Comportamiento Inapropiado',
                        'producto_defectuoso' => 'Producto Defectuoso',
                        'entrega_tardía' => 'Entrega Tardía',
                        'falta_respeto' => 'Falta de Respeto',
                        'estafa' => 'Posible Estafa',
                        'contenido_inapropiado' => 'Contenido Inapropiado',
                        'spam' => 'Spam',
                        'otro' => 'Otro',
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
