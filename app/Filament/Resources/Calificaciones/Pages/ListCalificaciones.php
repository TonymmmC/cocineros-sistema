<?php

namespace App\Filament\Resources\Calificaciones\Pages;

use App\Filament\Resources\Calificaciones\CalificacionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCalificaciones extends ListRecords
{
    protected static string $resource = CalificacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nueva Calificación'),
        ];
    }
}
