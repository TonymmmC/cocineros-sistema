<?php

namespace App\Filament\Resources\Transacciones;

use App\Filament\Resources\Transacciones\Pages\CreateTransaccion;
use App\Filament\Resources\Transacciones\Pages\EditTransaccion;
use App\Filament\Resources\Transacciones\Pages\ListTransacciones;
use App\Filament\Resources\Transacciones\Schemas\TransaccionForm;
use App\Filament\Resources\Transacciones\Tables\TransaccionesTable;
use App\Models\Transaccion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class TransaccionResource extends Resource
{
    protected static ?string $model = Transaccion::class;

    /** @phpstan-ignore-next-line */
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'Transacciones';

    protected static ?string $modelLabel = 'Transacción';

    protected static ?string $pluralModelLabel = 'Transacciones';

    protected static ?string $recordTitleAttribute = 'codigo_transaccion';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return TransaccionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransaccionesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTransacciones::route('/'),
            'create' => CreateTransaccion::route('/create'),
            'edit' => EditTransaccion::route('/{record}/edit'),
        ];
    }
}
