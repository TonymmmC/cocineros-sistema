<?php

namespace App\Filament\Resources\Reportes\Pages;

use App\Filament\Resources\Reportes\ReporteUsuarioResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReporteUsuario extends EditRecord
{
    protected static string $resource = ReporteUsuarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('Ver Detalles'),
            Actions\DeleteAction::make()
                ->label('Eliminar'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Reporte actualizado exitosamente';
    }
}
