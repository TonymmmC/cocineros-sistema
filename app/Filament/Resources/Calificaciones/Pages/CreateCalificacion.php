<?php

namespace App\Filament\Resources\Calificaciones\Pages;

use App\Filament\Resources\Calificaciones\CalificacionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCalificacion extends CreateRecord
{
    protected static string $resource = CalificacionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Calificación creada exitosamente';
    }
}
