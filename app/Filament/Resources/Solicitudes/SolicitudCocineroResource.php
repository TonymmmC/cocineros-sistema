<?php

namespace App\Filament\Resources\Solicitudes;

use App\Filament\Resources\Solicitudes\Pages\ListSolicitudesCocinero;
use App\Filament\Resources\Solicitudes\Tables\SolicitudesCocineroTable;
use App\Models\SolicitudCocinero;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class SolicitudCocineroResource extends Resource
{
    protected static ?string $model = SolicitudCocinero::class;

    /** @phpstan-ignore-next-line */
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Solicitudes Cocinero';

    protected static ?string $modelLabel = 'Solicitud';

    protected static ?string $pluralModelLabel = 'Solicitudes de Cocinero';

    protected static ?string $recordTitleAttribute = 'nombre_completo';

    // protected static ?string $navigationGroup = 'Gestión';

    protected static ?int $navigationSort = 2;

    public static function table(Table $table): Table
    {
        return SolicitudesCocineroTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSolicitudesCocinero::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('estado', 'pendiente')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $pendientes = static::getModel()::where('estado', 'pendiente')->count();

        return $pendientes > 0 ? 'warning' : 'gray';
    }
}
