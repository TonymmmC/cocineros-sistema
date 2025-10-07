<?php

namespace App\Filament\Resources\Cocineros;

use App\Filament\Resources\Cocineros\Pages\CreateCocinero;
use App\Filament\Resources\Cocineros\Pages\EditCocinero;
use App\Filament\Resources\Cocineros\Pages\ListCocineros;
use App\Filament\Resources\Cocineros\Schemas\CocineroForm;
use App\Filament\Resources\Cocineros\Tables\CocinerosTable;
use App\Models\Cocinero;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class CocineroResource extends Resource
{
    protected static ?string $model = Cocinero::class;

    /** @phpstan-ignore-next-line */
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationLabel = 'Cocineros';

    protected static ?string $modelLabel = 'Cocinero';

    protected static ?string $pluralModelLabel = 'Cocineros';

    protected static ?string $recordTitleAttribute = 'nombre_completo';

    // protected static ?string $navigationGroup = 'Gestión de Usuarios';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return CocineroForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CocinerosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCocineros::route('/'),
            'create' => CreateCocinero::route('/create'),
            'edit' => EditCocinero::route('/{record}/edit'),
        ];
    }
}
