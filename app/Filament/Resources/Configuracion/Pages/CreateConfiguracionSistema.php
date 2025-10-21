<?php

namespace App\Filament\Resources\Configuracion\Pages;

use App\Filament\Resources\Configuracion\ConfiguracionSistemaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateConfiguracionSistema extends CreateRecord
{
    protected static string $resource = ConfiguracionSistemaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Configuración creada exitosamente';
    }
}
