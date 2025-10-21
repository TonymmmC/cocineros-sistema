<?php

namespace App\Filament\Resources\Reportes;

use App\Filament\Resources\Reportes\Pages\CreateReporteUsuario;
use App\Filament\Resources\Reportes\Pages\EditReporteUsuario;
use App\Filament\Resources\Reportes\Pages\ListReportesUsuario;
use App\Filament\Resources\Reportes\Schemas\ReporteUsuarioForm;
use App\Filament\Resources\Reportes\Tables\ReportesUsuarioTable;
use App\Models\ReporteUsuario;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ReporteUsuarioResource extends Resource
{
    protected static ?string $model = ReporteUsuario::class;

    /** @phpstan-ignore-next-line */
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static ?string $navigationLabel = 'Reportes de Usuario';

    protected static ?string $modelLabel = 'Reporte';

    protected static ?string $pluralModelLabel = 'Reportes';

    protected static ?string $recordTitleAttribute = 'motivo';

    // protected static string | BackedEnum | null $navigationGroup = 'Moderación';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ReporteUsuarioForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReportesUsuarioTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListReportesUsuario::route('/'),
            'create' => CreateReporteUsuario::route('/create'),
            'edit' => EditReporteUsuario::route('/{record}/edit'),
        ];
    }
}
