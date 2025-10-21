<?php

namespace App\Filament\Resources\Transacciones\Pages;

use App\Filament\Resources\Transacciones\TransaccionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaccion extends CreateRecord
{
    protected static string $resource = TransaccionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Transacción creada exitosamente';
    }
}
