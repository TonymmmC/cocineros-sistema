<?php

namespace App\Filament\Resources\Mensajes\Pages;

use App\Filament\Resources\Mensajes\MensajeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMensaje extends CreateRecord
{
    protected static string $resource = MensajeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Mensaje creado exitosamente';
    }
}
