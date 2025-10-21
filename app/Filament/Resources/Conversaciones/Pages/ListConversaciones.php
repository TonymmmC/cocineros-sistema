<?php

namespace App\Filament\Resources\Conversaciones\Pages;

use App\Filament\Resources\Conversaciones\ConversacionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConversaciones extends ListRecords
{
    protected static string $resource = ConversacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nueva Conversación'),
        ];
    }
}
