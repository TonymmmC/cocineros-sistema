<?php

namespace App\Filament\Resources\Clientes\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ClientesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto_perfil')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl('/images/default-avatar.png')
                    ->toggleable(),

                TextColumn::make('nombre_completo')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap()
                    ->limit(30),

                TextColumn::make('user.email')
                    ->label('Email')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email copiado')
                    ->icon('heroicon-o-envelope')
                    ->wrap()
                    ->limit(30)
                    ->toggleable(),

                TextColumn::make('user.phone')
                    ->label('Teléfono')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Teléfono copiado')
                    ->icon('heroicon-o-phone')
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('preferencias_alimentarias')
                    ->label('Preferencias')
                    ->badge()
                    ->separator(',')
                    ->color('info')
                    ->wrap()
                    ->limit(50)
                    ->placeholder('Sin preferencias')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('pedidos_count')
                    ->label('Pedidos')
                    ->counts('pedidos')
                    ->badge()
                    ->color('success')
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('user.is_active')
                    ->label('Activo')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->alignCenter()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Registrado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('user.is_active')
                    ->label('Estado')
                    ->native(false)
                    ->placeholder('Todos')
                    ->trueLabel('Activos')
                    ->falseLabel('Inactivos')
                    ->queries(
                        true: fn ($query) => $query->whereHas('user', fn ($q) => $q->where('is_active', true)),
                        false: fn ($query) => $query->whereHas('user', fn ($q) => $q->where('is_active', false)),
                    ),

                TernaryFilter::make('user.is_verified')
                    ->label('Verificación')
                    ->native(false)
                    ->placeholder('Todos')
                    ->trueLabel('Verificados')
                    ->falseLabel('No verificados')
                    ->queries(
                        true: fn ($query) => $query->whereHas('user', fn ($q) => $q->where('is_verified', true)),
                        false: fn ($query) => $query->whereHas('user', fn ($q) => $q->where('is_verified', false)),
                    ),

                TernaryFilter::make('has_preferencias')
                    ->label('Preferencias Alimentarias')
                    ->native(false)
                    ->placeholder('Todos')
                    ->trueLabel('Con preferencias')
                    ->falseLabel('Sin preferencias')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('preferencias_alimentarias'),
                        false: fn ($query) => $query->whereNull('preferencias_alimentarias')
                            ->orWhere('preferencias_alimentarias', '[]'),
                    ),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Editar')
                    ->modal()
                    ->modalHeading('Editar Cliente')
                    ->modalSubmitActionLabel('Guardar')
                    ->modalCancelActionLabel('Cancelar')
                    ->successNotificationTitle('Cliente actualizado exitosamente'),

                Action::make('toggle_active')
                    ->label(fn ($record) => $record->user->is_active ? 'Desactivar' : 'Activar')
                    //->icon(fn ($record) => $record->user->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn ($record) => $record->user->is_active ? 'danger' : 'success')
                    ->requiresConfirmation()
                    ->modalHeading(fn ($record) => $record->user->is_active ? 'Desactivar Cliente' : 'Activar Cliente')
                    ->modalDescription(fn ($record) => $record->user->is_active
                        ? '¿Estás seguro de desactivar este cliente? No podrá realizar pedidos.'
                        : '¿Estás seguro de activar este cliente?')
                    ->modalSubmitActionLabel('Confirmar')
                    ->modalCancelActionLabel('Cancelar')
                    ->action(fn ($record) => $record->user->update(['is_active' => !$record->user->is_active]))
                    ->successNotificationTitle(fn ($record) => $record->user->is_active ? 'Cliente activado' : 'Cliente desactivado'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Eliminar seleccionados')
                        ->requiresConfirmation()
                        ->modalHeading('Eliminar Clientes')
                        ->modalDescription('¿Estás seguro de eliminar los clientes seleccionados? Esta acción no se puede deshacer.')
                        ->modalSubmitActionLabel('Sí, eliminar')
                        ->modalCancelActionLabel('Cancelar')
                        ->successNotificationTitle('Clientes eliminados exitosamente'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('No hay clientes registrados')
            ->emptyStateDescription('Comienza registrando el primer cliente.')
            ->emptyStateIcon('heroicon-o-users');
    }
}
