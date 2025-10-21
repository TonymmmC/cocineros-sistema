<?php

namespace App\Filament\Resources\Calificaciones;

use App\Filament\Resources\Calificaciones\Pages\CreateCalificacion;
use App\Filament\Resources\Calificaciones\Pages\EditCalificacion;
use App\Filament\Resources\Calificaciones\Pages\ListCalificaciones;
use App\Filament\Resources\Calificaciones\Schemas\CalificacionForm;
use App\Filament\Resources\Calificaciones\Tables\CalificacionesTable;
use App\Models\Calificacion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class CalificacionResource extends Resource
{
    protected static ?string $model = Calificacion::class;

    /** @phpstan-ignore-next-line */
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'Calificaciones';

    protected static ?string $modelLabel = 'Calificación';

    protected static ?string $pluralModelLabel = 'Calificaciones';

    protected static ?string $recordTitleAttribute = 'puntuacion';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return CalificacionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CalificacionesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCalificaciones::route('/'),
            'create' => CreateCalificacion::route('/create'),
            'edit' => EditCalificacion::route('/{record}/edit'),
        ];
    }
}
