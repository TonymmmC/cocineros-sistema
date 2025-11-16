<div class="space-y-4">
    {{-- Información del Solicitante --}}
    <div class="rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <x-filament::icon icon="heroicon-o-user" class="w-5 h-5" />
                Información del Solicitante
            </h3>
        </div>
        <div class="p-4">
            <dl class="grid grid-cols-2 gap-x-4 gap-y-3">
                <div class="col-span-2 sm:col-span-1">
                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Usuario</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $record->user->name }}</dd>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Email</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white break-all">{{ $record->user->email }}</dd>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Nombre Completo</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $record->nombre_completo }}</dd>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Cédula (CI)</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $record->ci }}</dd>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Teléfono</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $record->user->phone ?? 'No especificado' }}</dd>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Radio de Entrega</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            <x-filament::icon icon="heroicon-o-map-pin" class="w-3.5 h-3.5" />
                            {{ $record->radio_entrega_km }} km
                        </span>
                    </dd>
                </div>
                <div class="col-span-2">
                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Dirección</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $record->direccion }}</dd>
                </div>
            </dl>
        </div>
    </div>

    {{-- Documento de Identidad --}}
    <div class="rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <x-filament::icon icon="heroicon-o-identification" class="w-5 h-5" />
                Documento de Identidad
            </h3>
        </div>
        <div class="p-4 bg-gray-50 dark:bg-gray-900">
            <div class="flex justify-center">
                <div class="relative group">
                    <img
                        src="{{ Storage::disk('public')->url($record->documento_ci_path) }}"
                        alt="Documento CI"
                        class="max-w-full h-auto rounded-lg shadow-lg border-2 border-gray-300 dark:border-gray-600 cursor-pointer transition-transform hover:scale-105"
                        style="max-height: 500px;"
                        onclick="window.open(this.src, '_blank')"
                    >
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-black/10 rounded-lg">
                        <span class="bg-white dark:bg-gray-800 px-3 py-2 rounded-lg shadow-lg text-sm font-medium flex items-center gap-2">
                            <x-filament::icon icon="heroicon-o-magnifying-glass-plus" class="w-4 h-4" />
                            Click para ampliar
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Información Profesional --}}
    <div class="rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <x-filament::icon icon="heroicon-o-briefcase" class="w-5 h-5" />
                Información Profesional
            </h3>
        </div>
        <div class="p-4">
            <dl class="space-y-4">
                <div>
                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Especialidades Culinarias</dt>
                    <dd class="flex flex-wrap gap-2">
                        @foreach($record->especialidades as $especialidad)
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200 border border-orange-200 dark:border-orange-800">
                                <x-filament::icon icon="heroicon-o-fire" class="w-3.5 h-3.5" />
                                {{ $especialidad }}
                            </span>
                        @endforeach
                    </dd>
                </div>

                @if($record->certificaciones && count($record->certificaciones) > 0)
                <div>
                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Certificaciones</dt>
                    <dd class="flex flex-wrap gap-2">
                        @foreach($record->certificaciones as $certificacion)
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 border border-green-200 dark:border-green-800">
                                <x-filament::icon icon="heroicon-o-academic-cap" class="w-3.5 h-3.5" />
                                {{ $certificacion }}
                            </span>
                        @endforeach
                    </dd>
                </div>
                @endif

                <div>
                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Biografía Profesional</dt>
                    <dd class="text-sm text-gray-900 dark:text-white leading-relaxed bg-gray-50 dark:bg-gray-900 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
                        {{ $record->bio }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    {{-- Estado --}}
    <div class="rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <x-filament::icon icon="heroicon-o-clipboard-document-check" class="w-5 h-5" />
                Estado de la Solicitud
            </h3>
        </div>
        <div class="p-4">
            <dl class="grid grid-cols-2 gap-x-4 gap-y-3">
                <div class="col-span-2 sm:col-span-1">
                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Estado Actual</dt>
                    <dd class="mt-1">
                        @if($record->estado === 'pendiente')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 border border-yellow-200 dark:border-yellow-800">
                                <x-filament::icon icon="heroicon-o-clock" class="w-4 h-4" />
                                Pendiente de Revisión
                            </span>
                        @elseif($record->estado === 'aprobado')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 border border-green-200 dark:border-green-800">
                                <x-filament::icon icon="heroicon-o-check-circle" class="w-4 h-4" />
                                Aprobado
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 border border-red-200 dark:border-red-800">
                                <x-filament::icon icon="heroicon-o-x-circle" class="w-4 h-4" />
                                Rechazado
                            </span>
                        @endif
                    </dd>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Fecha de Solicitud</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white flex items-center gap-1.5">
                        <x-filament::icon icon="heroicon-o-calendar" class="w-4 h-4" />
                        {{ $record->created_at->format('d/m/Y H:i') }}
                    </dd>
                </div>
                @if($record->revisado_en)
                <div class="col-span-2 sm:col-span-1">
                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Fecha de Revisión</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white flex items-center gap-1.5">
                        <x-filament::icon icon="heroicon-o-calendar" class="w-4 h-4" />
                        {{ $record->revisado_en->format('d/m/Y H:i') }}
                    </dd>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Revisado Por</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white flex items-center gap-1.5">
                        <x-filament::icon icon="heroicon-o-user-circle" class="w-4 h-4" />
                        {{ $record->revisor->name ?? 'N/A' }}
                    </dd>
                </div>
                @endif
                @if($record->estado === 'rechazado' && $record->razon_rechazo)
                <div class="col-span-2">
                    <dt class="text-xs font-medium text-red-600 dark:text-red-400 uppercase tracking-wide mb-2 flex items-center gap-1.5">
                        <x-filament::icon icon="heroicon-o-exclamation-triangle" class="w-4 h-4" />
                        Razón del Rechazo
                    </dt>
                    <dd class="text-sm text-red-900 dark:text-red-200 bg-red-50 dark:bg-red-900/20 p-4 rounded-lg border-l-4 border-red-500">
                        {{ $record->razon_rechazo }}
                    </dd>
                </div>
                @endif
            </dl>
        </div>
    </div>
</div>
