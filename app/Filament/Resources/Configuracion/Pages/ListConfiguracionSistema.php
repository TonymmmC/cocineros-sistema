<?php

namespace App\Filament\Resources\Configuracion\Pages;

use App\Filament\Resources\Configuracion\ConfiguracionSistemaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConfiguracionSistema extends ListRecords
{
    protected static string $resource = ConfiguracionSistemaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nueva Configuración'),
        ];
    }
}
