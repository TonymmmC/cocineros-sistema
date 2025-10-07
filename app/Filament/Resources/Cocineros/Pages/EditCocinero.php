<?php

namespace App\Filament\Resources\Cocineros\Pages;

use App\Filament\Resources\Cocineros\CocineroResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCocinero extends EditRecord
{
    protected static string $resource = CocineroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
