<?php

namespace App\Filament\Resources\Conversaciones\Pages;

use App\Filament\Resources\Conversaciones\ConversacionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConversacion extends EditRecord
{
    protected static string $resource = ConversacionResource::class;

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
        return 'Conversación actualizada exitosamente';
    }
}
