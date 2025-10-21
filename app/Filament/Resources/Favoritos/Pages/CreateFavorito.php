<?php

namespace App\Filament\Resources\Favoritos\Pages;

use App\Filament\Resources\Favoritos\FavoritoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFavorito extends CreateRecord
{
    protected static string $resource = FavoritoResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Favorito creado exitosamente';
    }
}
