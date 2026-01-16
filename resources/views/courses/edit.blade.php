<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark mb-0">
            {{ __('Editar Curso') }}: <span class="text-primary">{{ $course->title }}</span>
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="card shadow-sm border-0 p-4">

                {{-- Formulario de Edición --}}
                <form method="POST" action="{{ route('seller.courses.update', $course) }}">
                    @csrf
                    @method('PUT')

                    <h3 class="h5 fw-bold text-dark mb-4 border-bottom pb-2">{{ __('Detalles Principales del Curso') }}
                    </h3>

                    {{-- Título --}}
                    <div class="mb-3">
                        <x-input-label for="title" :value="__('Título del Curso')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 d-block w-100"
                            :value="old('title', $course->title)" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    {{-- Encabezado (Header) --}}
                    <div class="mb-3">
                        <x-input-label for="header" :value="__('Encabezado (Resumen Breve)')" />
                        <x-text-input id="header" name="header" type="text" class="mt-1 d-block w-100"
                            :value="old('header', $course->header)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('header')" />
                    </div>

                    {{-- Descripción --}}
                    <div class="mb-3">
                        <x-input-label for="description" :value="__('Descripción Completa')" />
                        <textarea id="description" name="description" class="form-control mt-1" rows="5"
                            required>{{ old('description', $course->description) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    {{-- Precio --}}
                    <div class="mb-3">
                        <x-input-label for="price" :value="__('Precio ($)')" />
                        <div class="input-group mt-1">
                            <span class="input-group-text">$</span>
                            <x-text-input id="price" name="price" type="number" step="0.01" class="form-control"
                                :value="old('price', $course->price)" required />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('price')" />
                    </div>

                    {{-- Fecha Programada --}}
                    <div class="mb-3">
                        <x-input-label for="scheduled_date" :value="__('Fecha Programada')" />
                        <x-text-input id="scheduled_date" name="scheduled_date" type="datetime-local"
                            class="mt-1 d-block w-100" :value="old('scheduled_date', $course->scheduled_date->format('Y-m-d\TH:i'))" required />
                        <x-input-error class="mt-2" :messages="$errors->get('scheduled_date')" />
                    </div>

                    {{-- Publicado (Checkbox) --}}
                    <div class="mb-4 form-check">
                        <input id="is_published" name="is_published" type="checkbox" class="form-check-input" value="1"
                            @checked(old('is_published', $course->is_published))>
                        <label for="is_published" class="form-check-label">
                            {{ __('Publicar este curso ahora') }}
                        </label>
                    </div>

                    <div class="d-flex justify-content-end mb-5">
                        <a href="{{ route('seller.courses.index') }}" class="btn btn-outline-secondary me-2">
                            {{ __('Cancelar') }}
                        </a>
                        <x-primary-button>
                            {{ __('Guardar Cambios') }}
                        </x-primary-button>
                    </div>
                </form>


                {{-- AÑADIDO: GESTIÓN DE MÓDULOS (Fase 4.1) --}}
                <div class="border-top pt-5 mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="h5 fw-bold text-dark mb-0">{{ __('Gestión de Módulos (Contenido)') }}</h3>
                        <a href="{{ route('seller.modules.create', $course) }}">
                            <x-primary-button class="btn-success">
                                {{ __('+ Añadir Nuevo Módulo') }}
                            </x-primary-button>
                        </a>
                    </div>

                    @if($course->modules->isEmpty())
                        <div class="alert alert-light border text-center text-muted">Aún no hay módulos. Añade el contenido
                            del curso.</div>
                    @else
                        <div class="list-group shadow-sm">
                            @foreach ($course->modules as $module)
                                <div
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                                    <div class="fw-medium text-dark">
                                        <span class="badge bg-secondary me-2">{{ $module->sequence_order }}</span>
                                        {{ $module->title }}
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('seller.modules.edit', ['course' => $course->id, 'module' => $module->id]) }}"
                                            class="btn btn-outline-primary">{{ __('Editar') }}</a>
                                        <form
                                            action="{{ route('seller.modules.destroy', ['course' => $course->id, 'module' => $module->id]) }}"
                                            method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar módulo?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-outline-danger border-start-0 user-select-none">{{ __('Eliminar') }}</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                {{-- FIN GESTIÓN DE MÓDULOS --}}


                {{-- Formulario para Eliminar Curso (Permanente) --}}
                <div class="border-top pt-5">
                    <h3 class="h6 fw-bold text-danger mb-3">{{ __('Eliminar Curso') }}</h3>
                    <div class="alert alert-danger d-flex justify-content-between align-items-center p-4">
                        <p class="mb-0 small text-danger">
                            {{ __('Una vez eliminado, no se puede recuperar. Esto también elimina todos los registros de módulos e inscripciones.') }}
                        </p>

                        <form method="POST" action="{{ route('seller.courses.destroy', $course) }}">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>
                                {{ __('Eliminar Curso Permanentemente') }}
                            </x-danger-button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>