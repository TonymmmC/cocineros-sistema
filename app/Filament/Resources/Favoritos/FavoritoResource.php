<?php

namespace App\Filament\Resources\Favoritos;

use App\Filament\Resources\Favoritos\Pages\CreateFavorito;
use App\Filament\Resources\Favoritos\Pages\EditFavorito;
use App\Filament\Resources\Favoritos\Pages\ListFavoritos;
use App\Filament\Resources\Favoritos\Schemas\FavoritoForm;
use App\Filament\Resources\Favoritos\Tables\FavoritosTable;
use App\Models\Favorito;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class FavoritoResource extends Resource
{
    protected static ?string $model = Favorito::class;

    /** @phpstan-ignore-next-line */
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationLabel = 'Favoritos';

    protected static ?string $modelLabel = 'Favorito';

    protected static ?string $pluralModelLabel = 'Favoritos';

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?int $navigationSort = 8;

    public static function form(Schema $schema): Schema
    {
        return FavoritoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FavoritosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFavoritos::route('/'),
            'create' => CreateFavorito::route('/create'),
            'edit' => EditFavorito::route('/{record}/edit'),
        ];
    }
}
