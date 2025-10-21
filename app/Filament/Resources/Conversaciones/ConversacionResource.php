<?php

namespace App\Filament\Resources\Conversaciones;

use App\Filament\Resources\Conversaciones\Pages\CreateConversacion;
use App\Filament\Resources\Conversaciones\Pages\EditConversacion;
use App\Filament\Resources\Conversaciones\Pages\ListConversaciones;
use App\Filament\Resources\Conversaciones\Schemas\ConversacionForm;
use App\Filament\Resources\Conversaciones\Tables\ConversacionesTable;
use App\Models\Conversacion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ConversacionResource extends Resource
{
    protected static ?string $model = Conversacion::class;

    /** @phpstan-ignore-next-line */
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-oval-left-ellipsis';

    protected static ?string $navigationLabel = 'Conversaciones';

    protected static ?string $modelLabel = 'Conversación';

    protected static ?string $pluralModelLabel = 'Conversaciones';

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return ConversacionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConversacionesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConversaciones::route('/'),
            'create' => CreateConversacion::route('/create'),
            'edit' => EditConversacion::route('/{record}/edit'),
        ];
    }
}
