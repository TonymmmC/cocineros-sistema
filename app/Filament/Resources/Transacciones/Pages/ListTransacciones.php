<?php

namespace App\Filament\Resources\Transacciones\Pages;

use App\Filament\Resources\Transacciones\TransaccionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransacciones extends ListRecords
{
    protected static string $resource = TransaccionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nueva Transacción'),
        ];
    }
}
