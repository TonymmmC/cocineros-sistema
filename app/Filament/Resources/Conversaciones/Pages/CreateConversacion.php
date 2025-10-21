<?php

namespace App\Filament\Resources\Conversaciones\Pages;

use App\Filament\Resources\Conversaciones\ConversacionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateConversacion extends CreateRecord
{
    protected static string $resource = ConversacionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Conversación creada exitosamente';
    }
}
