<?php

namespace App\Filament\Resources\Solicitudes\Tables;

use App\Models\Cocinero;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class SolicitudesCocineroTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Usuario')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold),

                TextColumn::make('nombre_completo')
                    ->label('Nombre Completo')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('ci')
                    ->label('CI')
                    ->searchable()
                    ->copyable(),

                ImageColumn::make('documento_ci_path')
                    ->label('Doc. CI')
                    ->disk('public')
                    ->square(),

                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),

                TextColumn::make('especialidades')
                    ->label('Especialidades')
                    ->badge()
                    ->separator(',')
                    ->limit(2)
                    ->toggleable(),

                TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendiente' => 'warning',
                        'aprobado' => 'success',
                        'rechazado' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pendiente' => 'Pendiente',
                        'aprobado' => 'Aprobado',
                        'rechazado' => 'Rechazado',
                    })
                    ->sortable(),

                TextColumn::make('revisado_en')
                    ->label('Revisado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Sin revisar')
                    ->toggleable(),

                TextColumn::make('revisor.name')
                    ->label('Revisado por')
                    ->placeholder('N/A')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Fecha Solicitud')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'aprobado' => 'Aprobado',
                        'rechazado' => 'Rechazado',
                    ])
                    ->default('pendiente'),
            ])
            ->recordActions([
                Action::make('ver')
                    ->label('Ver Detalles')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading(fn ($record) => 'Solicitud de ' . $record->nombre_completo)
                    ->modalWidth('5xl')
                    ->fillForm(fn ($record) => [
                        'usuario' => $record->user->name,
                        'email' => $record->user->email,
                        'nombre' => $record->nombre_completo,
                        'ci' => $record->ci,
                        'telefono' => $record->user->phone ?? 'No especificado',
                        'radio' => $record->radio_entrega_km . ' km',
                        'direccion' => $record->direccion,
                        'imagen_url' => asset('storage/' . $record->documento_ci_path),
                        'especialidades' => implode(', ', $record->especialidades),
                        'certificaciones' => $record->certificaciones ? implode(', ', $record->certificaciones) : null,
                        'bio' => $record->bio,
                        'estado_texto' => match($record->estado) {
                            'pendiente' => 'Pendiente de Revisión',
                            'aprobado' => 'Aprobado',
                            'rechazado' => 'Rechazado',
                        },
                        'fecha_solicitud' => $record->created_at->format('d/m/Y H:i'),
                        'fecha_revision' => $record->revisado_en ? $record->revisado_en->format('d/m/Y H:i') : null,
                        'revisor' => $record->revisor->name ?? null,
                        'razon_rechazo' => $record->razon_rechazo,
                    ])
                    ->schema([
                        Section::make('Información del Solicitante')
                            ->icon('heroicon-o-user')
                            ->schema([
                                TextEntry::make('usuario')->label('Usuario'),
                                TextEntry::make('email')->label('Email'),
                                TextEntry::make('nombre')->label('Nombre Completo'),
                                TextEntry::make('ci')->label('Cédula (CI)'),
                                TextEntry::make('telefono')->label('Teléfono'),
                                TextEntry::make('radio')->label('Radio de Entrega'),
                                TextEntry::make('direccion')->label('Dirección')->columnSpanFull(),
                            ])->columns(2),

                        Section::make('Documento de Identidad')
                            ->icon('heroicon-o-identification')
                            ->schema([
                                ViewField::make('imagen_url')
                                    ->view('filament.forms.components.image-viewer')
                                    ->columnSpanFull(),
                            ]),

                        Section::make('Información Profesional')
                            ->icon('heroicon-o-briefcase')
                            ->schema([
                                TextEntry::make('especialidades')->label('Especialidades')->columnSpanFull(),
                                TextEntry::make('certificaciones')
                                    ->label('Certificaciones')
                                    ->visible(fn ($get) => $get('certificaciones'))
                                    ->columnSpanFull(),
                                TextEntry::make('bio')->label('Biografía')->columnSpanFull(),
                            ]),

                        Section::make('Estado de la Solicitud')
                            ->icon('heroicon-o-clipboard-document-check')
                            ->schema([
                                TextEntry::make('estado_texto')->label('Estado Actual'),
                                TextEntry::make('fecha_solicitud')->label('Fecha Solicitud'),
                                TextEntry::make('fecha_revision')
                                    ->label('Fecha Revisión')
                                    ->visible(fn ($get) => $get('fecha_revision')),
                                TextEntry::make('revisor')
                                    ->label('Revisado Por')
                                    ->visible(fn ($get) => $get('revisor')),
                                TextEntry::make('razon_rechazo')
                                    ->label('Razón del Rechazo')
                                    ->visible(fn ($get) => $get('razon_rechazo'))
                                    ->columnSpanFull(),
                            ])->columns(2),
                    ])
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Cerrar'),

                Action::make('aprobar')
                    ->label('Aprobar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Aprobar Solicitud de Cocinero')
                    ->modalDescription('Esta acción convertirá al usuario en cocinero. Para confirmar, escribe exactamente "Aceptar solicitud" en el campo de abajo.')
                    ->fillForm([])
                    ->schema([
                        TextInput::make('confirmacion')
                            ->label('Confirmación')
                            ->placeholder('Escribe: Aceptar solicitud')
                            ->required()
                            ->rule('in:Aceptar solicitud')
                            ->validationMessages([
                                'in' => 'Debes escribir exactamente "Aceptar solicitud" para confirmar.',
                            ]),
                    ])
                    ->modalSubmitActionLabel('Aprobar Solicitud')
                    ->modalCancelActionLabel('Cancelar')
                    ->visible(fn ($record) => $record->estado === 'pendiente')
                    ->action(function ($record) {
                        try {
                            DB::beginTransaction();

                            Cocinero::create([
                                'user_id' => $record->user_id,
                                'nombre_completo' => $record->nombre_completo,
                                'ci' => $record->ci,
                                'bio' => $record->bio,
                                'especialidades' => $record->especialidades,
                                'certificaciones' => $record->certificaciones,
                                'direccion' => $record->direccion,
                                'latitud' => $record->latitud,
                                'longitud' => $record->longitud,
                                'radio_entrega_km' => $record->radio_entrega_km,
                                'esta_disponible' => true,
                            ]);

                            $record->user->update(['role' => 'cocinero']);

                            $record->update([
                                'estado' => 'aprobado',
                                'revisado_en' => now(),
                                'revisado_por' => \Illuminate\Support\Facades\Auth::id(),
                            ]);

                            DB::commit();

                            \Filament\Notifications\Notification::make()
                                ->success()
                                ->title('Solicitud aprobada correctamente')
                                ->body('El usuario ahora es cocinero y puede comenzar a publicar productos.')
                                ->send();

                        } catch (\Exception $e) {
                            DB::rollBack();

                            \Filament\Notifications\Notification::make()
                                ->danger()
                                ->title('Error al aprobar la solicitud')
                                ->body($e->getMessage())
                                ->send();
                        }
                    }),

                Action::make('rechazar')
                    ->label('Rechazar')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Rechazar Solicitud de Cocinero')
                    ->modalDescription('Indica la razón del rechazo para que el usuario pueda corregir su solicitud.')
                    ->fillForm([])
                    ->schema([
                        Textarea::make('razon_rechazo')
                            ->label('Razón del Rechazo')
                            ->required()
                            ->rows(4)
                            ->placeholder('Ej: Documento de identidad no legible, información incompleta, etc.'),
                    ])
                    ->modalSubmitActionLabel('Rechazar Solicitud')
                    ->modalCancelActionLabel('Cancelar')
                    ->visible(fn ($record) => $record->estado === 'pendiente')
                    ->action(function ($record, array $data) {
                        $record->update([
                            'estado' => 'rechazado',
                            'razon_rechazo' => $data['razon_rechazo'],
                            'revisado_en' => now(),
                            'revisado_por' => \Illuminate\Support\Facades\Auth::id(),
                        ]);

                        \Filament\Notifications\Notification::make()
                            ->success()
                            ->title('Solicitud rechazada')
                            ->body('El usuario ha sido notificado.')
                            ->send();
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('No hay solicitudes')
            ->emptyStateDescription('Las solicitudes de cocineros aparecerán aquí.');
    }
}
