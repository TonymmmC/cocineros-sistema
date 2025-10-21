<?php

namespace App\Filament\Resources\Favoritos\Pages;

use App\Filament\Resources\Favoritos\FavoritoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFavorito extends EditRecord
{
    protected static string $resource = FavoritoResource::class;

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
        return 'Favorito actualizado exitosamente';
    }
}
