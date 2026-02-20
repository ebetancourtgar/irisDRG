<x-app-layout>
    {{-- Slot para el encabezado de la página --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                {{-- Icono con gradiente (Mismo estilo slate) --}}
                <div class="bg-gradient-to-br from-slate-700 to-slate-900 p-3 rounded-lg shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                        Programación de Soporte
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gestión de Servicios y Agenda Técnica</p>
                </div>
            </div>
            <div class="hidden md:flex items-center space-x-4">
                <div class="text-center px-4 py-2 bg-slate-700 rounded-lg">
                    <p class="text-2xl font-bold text-white">{{ $services->total() ?? count($services) }}</p>
                    <p class="text-xs text-gray-300">Servicios Totales</p>
                </div>
            </div>
        </div>
    </x-slot>

    {{-- Contenido principal de la página --}}
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Barra de acciones y búsqueda --}}
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                <form action="{{ route('services.index') }}" method="GET">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0 md:space-x-4">
                        
                        {{-- Búsqueda por texto --}}
                        <div class="flex-1 max-w-lg">
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-slate-500" 
                                    placeholder="Buscar por título, técnico, sucursal...">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                </div>
                            </div>
                        </div>

                        {{-- Filtro por Estatus (Adaptado de Categoría) --}}
                        <div class="flex items-center space-x-2">
                            <select name="status" onchange="this.form.submit()" 
                                    class="block w-full md:w-48 py-2.5 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-slate-500">
                                <option value="">Todos los estados</option>
                                <option value="pendiente" {{ request('status') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="en_proceso" {{ request('status') == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                <option value="finalizado" {{ request('status') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                                <option value="cancelado" {{ request('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>

                            <button type="submit" class="bg-slate-700 text-white px-4 py-2.5 rounded-lg hover:bg-slate-600 transition">
                                Filtrar
                            </button>
                            
                            @if(request()->anyFilled(['search', 'status']))
                                <a href="{{ route('services.index') }}" class="pl-4 bg-slate-700 text-red-600 px-4 py-2.5 rounded-lg hover:bg-slate-600 transition">Limpiar</a>
                            @endif
                        </div>

                        {{-- Botón Nuevo Servicio --}}
                        @can('manage schedules')
                        <a href="{{ route('services.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-slate-700 to-slate-900 rounded-lg font-semibold text-sm text-white shadow-lg hover:from-slate-800 hover:to-black transition-all">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Agendar Servicio
                        </a>
                        @endcan
                    </div>
                </form>
            </div>

            {{-- Vista DESKTOP: Tabla (oculta en móvil) --}}
            <div class="hidden md:block bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-slate-700 to-slate-800">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-100 uppercase tracking-wider">
                                    <div class="flex items-center space-x-2">
                                        <span>Servicio</span>
                                    </div>
                                </th>
                                

                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-100 uppercase tracking-wider">
                                    <span>Tipo & Fecha</span>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-100 uppercase tracking-wider">
                                    <span>Sucursal / Zona</span>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-100 uppercase tracking-wider">
                                    <span>Técnico Asignado</span>
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-100 uppercase tracking-wider">
                                    <span>Estado</span>
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-100 uppercase tracking-wider">
                                    <span>Acciones</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($services as $service)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                    {{-- Columna 1: Título y Descripción --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-lg flex items-center justify-center shadow-md">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $service->id }}</div>

                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $service->title }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 max-w-xs truncate">{{ $service->description ?? 'Sin detalles adicionales' }}</div>
                                            </div>

                                        </div>
                                    </td>
                                    
                                    {{-- Columna 2: Tipo y Fecha --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="inline-flex w-fit items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 mb-1">
                                                {{ $service->service_type }}
                                            </span>
                                            <span class="text-sm text-gray-600 dark:text-gray-300">
                                                <i class="far fa-clock mr-1"></i>
                                                {{ $service->scheduled_at->format('d/m/Y H:i') }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Columna 3: Sucursal --}}
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-700 dark:text-gray-200">
                                            {{ $service->branch->name }}
                                        </div>
                                        <div class="text-xs text-gray-500">{{ Str::limit($service->branch->address, 20) }}</div>
                                    </td>

                                    {{-- Columna 4: Técnico --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-6 w-6 rounded-full bg-gray-200 flex items-center justify-center text-xs">
                                                {{ substr($service->technician->name, 0, 1) }}
                                            </div>
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                                {{ $service->technician->name }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Columna 5: Estado (Badge Dinámico) --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $statusClasses = match($service->status) {
                                                'pendiente' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                'en_proceso' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                                'finalizado' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                                'cancelado' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium uppercase {{ $statusClasses }}">
                                            {{ ucfirst(str_replace('_', ' ', $service->status)) }}
                                        </span>
                                    </td>

                                    {{-- Columna 6: Acciones --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            @can('view', $service)
                                            <a href="{{ route('services.show', $service) }}" 
                                               class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-md shadow-sm hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5"
                                               title="Ver detalles">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            @endcan
                                            
                                            @can('update', $service)
                                            <a href="{{ route('services.edit', $service) }}" 
                                               class="inline-flex items-center px-3 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-medium rounded-md shadow-sm hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5"
                                               title="Editar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            @endcan
                                            
                                            @can('delete', $service)
                                            <form action="{{ route('services.destroy', $service) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de cancelar este servicio?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-md shadow-sm hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5"
                                                        title="Cancelar/Eliminar">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="bg-gray-100 dark:bg-gray-700 rounded-full p-6 mb-4">
                                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No hay servicios programados</h3>
                                            <p class="text-gray-500 dark:text-gray-400 mb-6">Comienza agendando tu primera visita técnica</p>
                                            
                                            @can('crear programacion')
                                            <a href="{{ route('services.create') }}" 
                                               class="inline-flex items-center px-4 py-2 bg-slate-700 hover:bg-slate-800 text-white text-sm font-medium rounded-md shadow-sm transition-colors duration-200">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                                Agendar Servicio
                                            </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Paginación Desktop --}}
                @if(method_exists($services, 'links'))
                    <div class="bg-gray-50 dark:bg-gray-900 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $services->links() }}
                    </div>
                @endif
            </div>

            {{-- Vista MÓVIL: Cards (oculta en desktop) --}}
            <div class="md:hidden space-y-4">
                @forelse ($services as $service)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        {{-- Header del Card --}}
                        <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-4 py-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    {{-- Icono --}}
                                    <div class="flex-shrink-0 h-10 w-10 bg-white/10 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-bold text-white truncate">{{ $service->title }}</h3>
                                        <p class="text-xs text-gray-300">{{ $service->scheduled_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                                {{-- Estado en Móvil --}}
                                @php
                                    $statusDot = match($service->status) {
                                        'pendiente' => 'bg-yellow-400',
                                        'en_proceso' => 'bg-blue-400',
                                        'finalizado' => 'bg-green-400',
                                        'cancelado' => 'bg-red-400',
                                        default => 'bg-gray-400'
                                    };
                                @endphp
                                <div class="w-3 h-3 rounded-full {{ $statusDot }}" title="{{ $service->status }}"></div>
                            </div>
                        </div>

                        {{-- Contenido del Card --}}
                        <div class="p-4 space-y-3">
                            {{-- Fila 1: Sucursal --}}
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 mt-1">
                                    <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Sucursal</p>
                                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $service->branch }}
                                    </span>
                                </div>
                            </div>

                            {{-- Fila 2: Técnico --}}
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 mt-1">
                                    <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Técnico</p>
                                    <div class="text-sm text-gray-800 dark:text-gray-200">
                                        {{ $service->technician->name }}
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Fila 3: Tipo --}}
                             <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 mt-1">
                                    <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo de Servicio</p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-800">
                                        {{ $service->service_type }}
                                    </span>
                                </div>
                            </div>

                            {{-- Separador --}}
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-3"></div>

                            {{-- Botones de Acción Móvil --}}
                            <div class="grid grid-cols-3 gap-2">
                                @can('view', $service)
                                <a href="{{ route('services.show', $service) }}" 
                                class="inline-flex flex-col items-center justify-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg shadow-sm transition-all duration-200">
                                    <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Ver
                                </a>
                                @endcan
                                
                                @can('update', $service)
                                <a href="{{ route('services.edit', $service) }}" 
                                class="inline-flex flex-col items-center justify-center px-3 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-medium rounded-lg shadow-sm transition-all duration-200">
                                    <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Editar
                                </a>
                                @endcan
                                
                                @can('delete', $service)
                                <form action="{{ route('services.destroy', $service) }}" method="POST" class="inline" onsubmit="return confirm('¿Cancelar servicio?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            class="w-full inline-flex flex-col items-center justify-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg shadow-sm transition-all duration-200">
                                        <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Cancelar
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Estado vacío móvil --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 p-8">
                        <div class="flex flex-col items-center justify-center text-center">
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-full p-6 mb-4">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-base font-medium text-gray-900 dark:text-gray-100 mb-2">Sin agenda</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">No tienes servicios para mostrar</p>
                            @can('manage schedules')
                            <a href="{{ route('services.create') }}" 
                            class="inline-flex items-center px-4 py-2 bg-slate-700 hover:bg-slate-800 text-white text-sm font-medium rounded-lg shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Agendar
                            </a>
                            @endcan
                        </div>
                    </div>
                @endforelse

                {{-- Paginación móvil --}}
                @if(method_exists($services, 'links'))
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-4">
                        {{ $services->links() }}
                    </div>
                @endif
            </div>

            <x-industrial-footer />

        </div>
    </div>
</x-app-layout>