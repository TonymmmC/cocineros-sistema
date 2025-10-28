<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(30),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Email copiado')
                    ->icon('heroicon-o-envelope')
                    ->wrap()
                    ->limit(35),

                TextColumn::make('role')
                    ->label('Rol')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'superadmin' => 'danger',
                        'admin' => 'success',
                        'cocinero' => 'warning',
                        'cliente' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'superadmin' => 'Super Admin',
                        'admin' => 'Admin',
                        'cocinero' => 'Cocinero',
                        'cliente' => 'Cliente',
                        default => $state,
                    }),

                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Teléfono copiado')
                    ->icon('heroicon-o-phone')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_verified')
                    ->label('Verificado')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-no-symbol')
                    ->alignCenter(),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Rol')
                    ->options([
                        'superadmin' => 'Super Admin',
                        'admin' => 'Admin',
                        'cocinero' => 'Cocinero',
                        'cliente' => 'Cliente',
                    ])
                    ->native(false),

                TernaryFilter::make('is_verified')
                    ->label('Verificación')
                    ->placeholder('Todos')
                    ->trueLabel('Verificados')
                    ->falseLabel('No verificados')
                    ->native(false),

                TernaryFilter::make('is_active')
                    ->label('Estado')
                    ->placeholder('Todos')
                    ->trueLabel('Activos')
                    ->falseLabel('Inactivos')
                    ->native(false),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Editar')
                    ->modal()
                    ->modalHeading('Editar Usuario')
                    ->modalSubmitActionLabel('Guardar')
                    ->modalCancelActionLabel('Cancelar')
                    ->successNotificationTitle('Usuario actualizado')
                    ->visible(fn ($record) => $record->role !== 'superadmin'),

                Action::make('deactivate')
                    ->label('Eliminar')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Desactivar Usuario')
                    ->modalDescription('¿Estás seguro que deseas desactivar este usuario? El usuario no podrá acceder al sistema.')
                    ->modalSubmitActionLabel('Sí, desactivar')
                    ->modalCancelActionLabel('Cancelar')
                    ->action(fn ($record) => $record->update(['is_active' => false]))
                    ->successNotificationTitle('Usuario desactivado')
                    ->visible(fn ($record) => $record->is_active && $record->role !== 'superadmin'),

                Action::make('activate')
                    ->label('Activar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Activar Usuario')
                    ->modalDescription('¿Estás seguro que deseas activar este usuario?')
                    ->modalSubmitActionLabel('Sí, activar')
                    ->modalCancelActionLabel('Cancelar')
                    ->action(fn ($record) => $record->update(['is_active' => true]))
                    ->successNotificationTitle('Usuario activado')
                    ->visible(fn ($record) => !$record->is_active),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Desactivar seleccionados')
                        ->action(fn ($records) => $records->each->update(['is_active' => false]))
                        ->successNotificationTitle('Usuarios desactivados')
                        ->modalHeading('Desactivar Usuarios')
                        ->modalDescription('¿Estás seguro que deseas desactivar los usuarios seleccionados?')
                        ->modalSubmitActionLabel('Sí, desactivar')
                        ->modalCancelActionLabel('Cancelar'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('No hay usuarios')
            ->emptyStateDescription('Comienza creando tu primer usuario.');
    }
}
