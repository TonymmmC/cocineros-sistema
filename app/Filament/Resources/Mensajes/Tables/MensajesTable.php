<?php

namespace App\Filament\Resources\Mensajes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MensajesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('remitente.name')
                    ->label('Remitente')
                    ->sortable()
                    ->searchable()
                    ->limit(20),

                TextColumn::make('tipo')
                    ->label('Tipo')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'texto' => 'Texto',
                        'imagen' => 'Imagen',
                        'sistema' => 'Sistema',
                        default => ucfirst($state),
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'texto' => 'info',
                        'imagen' => 'success',
                        'sistema' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('mensaje')
                    ->label('Mensaje')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),

                IconColumn::make('leido')
                    ->label('Leído')
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
                SelectFilter::make('tipo')
                    ->label('Tipo')
                    ->options([
                        'texto' => 'Texto',
                        'imagen' => 'Imagen',
                        'sistema' => 'Sistema',
                    ]),

                SelectFilter::make('leido')
                    ->label('Estado')
                    ->options([
                        true => 'Leído',
                        false => 'No Leído',
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
