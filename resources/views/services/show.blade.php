<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-gradient-to-br from-slate-700 to-slate-900 p-3 rounded-lg shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                        Detalle de Servicio #{{ str_pad($service->id, 5, '0', STR_PAD_LEFT) }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Vista completa de la orden</p>
                </div>
            </div>

            <div class="flex space-x-2">
                {{-- Botón Editar (Solo si tiene permiso) --}}
                @can('update', $service)
                <a href="{{ route('services.edit', $service) }}" class="inline-flex items-center px-4 py-2 bg-amber-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-600 focus:outline-none focus:border-amber-700 focus:ring focus:ring-amber-200 active:bg-amber-600 disabled:opacity-25 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar
                </a>
                @endcan

                <a href="{{ route('services.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                    Regresar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border border-gray-200 dark:border-gray-700">
                
                {{-- Banner de Estado --}}
                @php
                    $statusColor = match($service->status) {
                        'pendiente' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                        'en_proceso' => 'bg-blue-100 text-blue-800 border-blue-200',
                        'finalizado' => 'bg-green-100 text-green-800 border-green-200',
                        'cancelado' => 'bg-red-100 text-red-800 border-red-200',
                        default => 'bg-gray-100 text-gray-800'
                    };
                @endphp
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-900/50">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado Actual:</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold uppercase border {{ $statusColor }}">
                        <span class="w-2 h-2 rounded-full bg-current mr-2 animate-pulse"></span>
                        {{ ucfirst(str_replace('_', ' ', $service->status)) }}
                    </span>
                </div>

              

                    {{-- PANEL DE ACCIONES DEL TÉCNICO --}}
                    @if(auth()->id() === $service->technician_id || auth()->user()->hasRole('Admin'))
                        
                        <div class="mt-4 px-6">
                            {{-- CASO 1: El servicio está PENDIENTE -> Botón Iniciar --}}
                            @if($service->status === 'pendiente')
                                <form action="{{ route('services.start', $service) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-semibold text-white text-sm uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition shadow-lg transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Iniciar Servicio (Check-In)
                                    </button>
                                </form>

                            {{-- CASO 2: El servicio está EN PROCESO -> Mostrar hora inicio y Botón Finalizar --}}
                            @elseif($service->status === 'en_proceso')
                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 flex flex-col md:flex-row items-center justify-between">
                                    <div class="mb-4 md:mb-0">
                                        <h4 class="text-blue-800 dark:text-blue-300 font-bold text-lg flex items-center">
                                            <span class="relative flex h-3 w-3 mr-3">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                                            </span>
                                            Servicio en Curso
                                        </h4>
                                        <p class="text-sm text-blue-600 dark:text-blue-400 mt-1">
                                            Iniciado: {{ $service->started_at->format('h:i A') }} 
                                            ({{ $service->started_at->diffForHumans() }})
                                        </p>
                                    </div>

                                    <form action="{{ route('services.finish', $service) }}" method="POST">
                                        @csrf
                                        <button type="submit" onclick="return confirm('¿Confirmas que has terminado el trabajo?')" 
                                            class="w-full md:w-auto inline-flex items-center justify-center px-6 py-3 bg-green-600 border border-transparent rounded-lg font-semibold text-white text-sm uppercase tracking-widest hover:bg-green-700 active:bg-green-800 transition shadow-lg transform hover:-translate-y-0.5">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Finalizar Trabajo
                                        </button>
                                    </form>
                                </div>

                            {{-- CASO 3: FINALIZADO -> Mostrar Resumen de tiempo --}}
                            @elseif($service->status === 'finalizado')
                                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                                    <div class="flex items-center text-green-800 dark:text-green-300">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span class="font-bold text-lg">Servicio Completado</span>
                                    </div>
                                    <div class="mt-2 grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="block text-gray-500">Inicio:</span>
                                            <span class="font-mono text-gray-800 dark:text-gray-200">{{ $service->started_at ? $service->started_at->format('h:i A') : '--' }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-gray-500">Fin:</span>
                                            <span class="font-mono text-gray-800 dark:text-gray-200">{{ $service->finished_at ? $service->finished_at->format('h:i A') : '--' }}</span>
                                        </div>
                                        <div class="col-span-2 border-t border-green-200 pt-2 mt-2">
                                            <span class="block text-gray-500">Tiempo Total de Respuesta:</span>
                                            <span class="font-bold text-lg text-green-700 dark:text-green-400">
                                                {{ $service->duration }} (Horas:Minutos)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                    @endif

                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    {{-- Sección Principal (2/3 del ancho) --}}
                    <div class="md:col-span-2 space-y-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $service->title }}</h3>
                            <div class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300">
                                {{ $service->service_type }}
                            </div>
                        </div>

                        <div class="prose dark:prose-invert max-w-none">
                            <h4 class="text-sm font-bold text-gray-900 dark:text-gray-200 uppercase tracking-wide mb-2">Descripción / Instrucciones</h4>
                            <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border border-gray-100 dark:border-gray-700 text-gray-700 dark:text-gray-300 whitespace-pre-line">
                                {{ $service->description ?? 'Sin descripción proporcionada.' }}
                            </div>
                        </div>
                    </div>

                    {{-- Sidebar Informativo (1/3 del ancho) --}}
                    <div class="space-y-6">
                        
                        {{-- Tarjeta de Fecha --}}
                        <div class="bg-white dark:bg-gray-700/50 p-4 rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm">
                            <h4 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-3">Fecha Programada</h4>
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-slate-600 dark:text-slate-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <div>
                                    <p class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                        {{ $service->scheduled_at->format('d/m/Y') }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $service->scheduled_at->format('h:i A') }}
                                        ({{ $service->scheduled_at->diffForHumans() }})
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Tarjeta de Técnico --}}
                        <div class="bg-white dark:bg-gray-700/50 p-4 rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm">
                            <h4 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-3">Técnico Asignado</h4>
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg mr-3 shadow-md">
                                    {{ substr($service->technician->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $service->technician->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $service->technician->email }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Tarjeta de Sucursal --}}
                        <div class="bg-white dark:bg-gray-700/50 p-4 rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm">
                            <h4 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-3">Ubicación</h4>
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-slate-600 dark:text-slate-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $service->branch->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $service->branch->address }}</p>
                                    @if($service->branch->phone)
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                            {{ $service->branch->phone }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                         <div class="pt-4 border-t border-gray-200 dark:border-gray-700 text-xs text-gray-400 text-center">
                            Orden creada el {{ $service->created_at->format('d/m/Y') }} por {{ $service->creator->name ?? 'Sistema' }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>