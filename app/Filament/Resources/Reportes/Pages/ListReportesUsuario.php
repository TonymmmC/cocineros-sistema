<?php

namespace App\Filament\Resources\Reportes\Pages;

use App\Filament\Resources\Reportes\ReporteUsuarioResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportesUsuario extends ListRecords
{
    protected static string $resource = ReporteUsuarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nuevo Reporte'),
        ];
    }

    // Tabs functionality can be added later if needed
}
