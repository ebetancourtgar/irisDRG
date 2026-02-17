<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-gradient-to-br from-slate-700 to-slate-900 p-3 rounded-lg shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                        Nueva Programación
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Agendar visita técnica</p>
                </div>
            </div>
            
            {{-- Botón Regresar --}}
            <a href="{{ route('services.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Cancelar
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border border-gray-200 dark:border-gray-700">
                
                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('services.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            {{-- Columna Izquierda: Detalles del Servicio --}}
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                    Información General
                                </h3>

                                {{-- Título --}}
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título del Servicio</label>
                                    <input type="text" name="title" id="title" required 
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-slate-500 focus:ring-slate-500 sm:text-sm"
                                        placeholder="Ej: Mantenimiento Preventivo CCTV"
                                        value="{{ old('title') }}">
                                    @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                {{-- Tipo de Servicio --}}
                                <div>
                                    <label for="service_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Servicio</label>
                                    <select name="service_type" id="service_type" required
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-slate-500 focus:ring-slate-500 sm:text-sm">
                                        <option value="Instalación">Instalación</option>
                                        <option value="Reparación">Reparación</option>
                                        <option value="Mantenimiento">Mantenimiento</option>
                                        <option value="Garantía">Garantía</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                    @error('service_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                {{-- Fecha Programada --}}
                                <div>
                                    <label for="scheduled_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha y Hora de Visita</label>
                                    <input type="datetime-local" name="scheduled_at" id="scheduled_at" required
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-slate-500 focus:ring-slate-500 sm:text-sm"
                                        value="{{ old('scheduled_at') }}">
                                    @error('scheduled_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- Columna Derecha: Asignación --}}
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                    Asignación y Ubicación
                                </h3>

                                {{-- Sucursal (Trigger del JS) --}}
                                <div>
                                    <label for="branch_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sucursal / Zona</label>
                                    <select name="branch_id" id="branch_select" required
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-slate-500 focus:ring-slate-500 sm:text-sm">
                                        <option value="">Seleccione una sucursal...</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('branch_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                {{-- Técnico (Filtrado por JS) --}}
                                <div>
                                    <label for="technician_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Técnico Responsable</label>
                                    <select name="technician_id" id="technician_select" required disabled
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-slate-500 focus:ring-slate-500 sm:text-sm disabled:bg-gray-100 disabled:text-gray-400 dark:disabled:bg-gray-800">
                                        <option value="">Primero seleccione sucursal</option>
                                        @foreach($technicians as $tech)
                                            <option value="{{ $tech->id }}" data-branch="{{ $tech->branch_id }}">
                                                {{ $tech->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p id="no_tech_message" class="mt-1 text-xs text-red-500 hidden">No hay técnicos disponibles en esta sucursal.</p>
                                    @error('technician_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                {{-- Descripción --}}
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Detalles Adicionales</label>
                                    <textarea name="description" id="description" rows="4"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-slate-500 focus:ring-slate-500 sm:text-sm"
                                        placeholder="Instrucciones específicas, herramientas necesarias, etc.">{{ old('description') }}</textarea>
                                </div>
                            </div>

                        </div>

                        {{-- Footer con Botón --}}
                        <div class="mt-8 flex items-center justify-end border-t border-gray-200 dark:border-gray-700 pt-6">
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-slate-700 to-slate-900 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:from-slate-800 hover:to-black focus:outline-none focus:border-slate-900 focus:ring focus:ring-slate-300 active:bg-slate-900 disabled:opacity-25 transition shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Confirmar Programación
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script para filtro dinámico --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const branchSelect = document.getElementById('branch_select');
            const techSelect = document.getElementById('technician_select');
            const allTechOptions = Array.from(techSelect.options);
            const noTechMessage = document.getElementById('no_tech_message');
        
            branchSelect.addEventListener('change', function() {
                const selectedBranchId = this.value;
                
                techSelect.innerHTML = ""; // Limpiar
                
                if (!selectedBranchId) {
                    techSelect.setAttribute('disabled', 'disabled');
                    techSelect.innerHTML = '<option value="">Primero seleccione sucursal</option>';
                    return;
                }
        
                let techsFound = 0;
                let defaultOption = document.createElement('option');
                defaultOption.text = "Seleccione un técnico...";
                defaultOption.value = "";
                techSelect.appendChild(defaultOption);
        
                allTechOptions.forEach(option => {
                    if (option.getAttribute('data-branch') == selectedBranchId) {
                        techSelect.appendChild(option.cloneNode(true));
                        techsFound++;
                    }
                });
        
                if (techsFound > 0) {
                    techSelect.removeAttribute('disabled');
                    noTechMessage.classList.add('hidden');
                } else {
                    techSelect.setAttribute('disabled', 'disabled');
                    techSelect.innerHTML = '<option value="">Sin cobertura</option>';
                    noTechMessage.classList.remove('hidden');
                }
            });
        });
    </script>
</x-app-layout>