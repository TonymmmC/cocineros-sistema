<?php

namespace App\Filament\Resources\Configuracion\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ConfiguracionSistemaTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('clave')
                    ->label('Clave')
                    ->sortable()
                    ->searchable()
                    ->limit(30),

                TextColumn::make('tipo')
                    ->label('Tipo')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'string' => 'Texto',
                        'number' => 'Número',
                        'boolean' => 'Verdadero/Falso',
                        'json' => 'JSON',
                        default => ucfirst($state),
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'string' => 'info',
                        'number' => 'success',
                        'boolean' => 'warning',
                        'json' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('valor')
                    ->label('Valor')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),

                IconColumn::make('es_publica')
                    ->label('Pública')
                    ->boolean()
                    ->trueIcon('heroicon-o-globe-alt')
                    ->falseIcon('heroicon-o-lock-closed')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 30 ? $state : null;
                    }),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('tipo')
                    ->label('Tipo')
                    ->options([
                        'string' => 'Texto',
                        'number' => 'Número',
                        'boolean' => 'Verdadero/Falso',
                        'json' => 'JSON',
                    ]),

                SelectFilter::make('es_publica')
                    ->label('Visibilidad')
                    ->options([
                        true => 'Pública',
                        false => 'Privada',
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
            ->defaultSort('clave');
    }
}
