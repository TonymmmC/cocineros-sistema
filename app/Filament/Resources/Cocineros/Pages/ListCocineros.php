<?php

namespace App\Filament\Resources\Cocineros\Pages;

use App\Filament\Resources\Cocineros\CocineroResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCocineros extends ListRecords
{
    protected static string $resource = CocineroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
