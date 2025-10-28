<?php

namespace App\Filament\Resources\Clientes\Pages;

use App\Filament\Resources\Clientes\ClienteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClientes extends ListRecords
{
    protected static string $resource = ClienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nuevo Cliente')
                ->modal()
                ->modalHeading('Nuevo Cliente')
                ->modalSubmitActionLabel('Crear')
                ->modalCancelActionLabel('Cancelar')
                ->successNotificationTitle('Cliente creado exitosamente'),
        ];
    }
}
