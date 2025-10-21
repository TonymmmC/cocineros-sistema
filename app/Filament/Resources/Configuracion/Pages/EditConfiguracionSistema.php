<?php

namespace App\Filament\Resources\Configuracion\Pages;

use App\Filament\Resources\Configuracion\ConfiguracionSistemaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConfiguracionSistema extends EditRecord
{
    protected static string $resource = ConfiguracionSistemaResource::class;

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
        return 'Configuración actualizada exitosamente';
    }
}
