<?php

namespace App\Filament\Resources\Reportes\Pages;

use App\Filament\Resources\Reportes\ReporteUsuarioResource;
use Filament\Resources\Pages\CreateRecord;

class CreateReporteUsuario extends CreateRecord
{
    protected static string $resource = ReporteUsuarioResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Reporte creado exitosamente';
    }
}
