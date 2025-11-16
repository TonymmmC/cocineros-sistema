<?php

namespace App\Filament\Resources\Solicitudes\Pages;

use App\Filament\Resources\Solicitudes\SolicitudCocineroResource;
use Filament\Resources\Pages\ListRecords;

class ListSolicitudesCocinero extends ListRecords
{
    protected static string $resource = SolicitudCocineroResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
