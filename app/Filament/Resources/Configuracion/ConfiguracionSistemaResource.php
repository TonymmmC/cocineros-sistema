<?php

namespace App\Filament\Resources\Configuracion;

use App\Filament\Resources\Configuracion\Pages\CreateConfiguracionSistema;
use App\Filament\Resources\Configuracion\Pages\EditConfiguracionSistema;
use App\Filament\Resources\Configuracion\Pages\ListConfiguracionSistema;
use App\Filament\Resources\Configuracion\Schemas\ConfiguracionSistemaForm;
use App\Filament\Resources\Configuracion\Tables\ConfiguracionSistemaTable;
use App\Models\ConfiguracionSistema;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ConfiguracionSistemaResource extends Resource
{
    protected static ?string $model = ConfiguracionSistema::class;

    /** @phpstan-ignore-next-line */
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Configuración';

    protected static ?string $modelLabel = 'Configuración';

    protected static ?string $pluralModelLabel = 'Configuraciones';

    protected static ?string $recordTitleAttribute = 'clave';

    // protected static string | BackedEnum | null $navigationGroup = 'Sistema';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ConfiguracionSistemaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConfiguracionSistemaTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConfiguracionSistema::route('/'),
            'create' => CreateConfiguracionSistema::route('/create'),
            'edit' => EditConfiguracionSistema::route('/{record}/edit'),
        ];
    }
}
