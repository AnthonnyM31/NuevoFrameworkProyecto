<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark mb-0">
            {{ __('Panel de Administración | Editar Usuario: ') }} <span class="text-primary">{{ $user->name }}</span>
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">

            {{-- AÑADIDO: Pestañas de Navegación del Administrador --}}
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link active fw-bold" href="{{ route('admin.users.index') }}">{{ __('Usuarios') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted"
                        href="{{ route('admin.courses.index') }}">{{ __('Cursos Globales') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted"
                        href="{{ route('admin.enrollments.index') }}">{{ __('Inscripciones Globales') }}</a>
                </li>
            </ul>
            {{-- FIN PESTAÑAS --}}

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="mt-1 d-block w-100" type="text" name="name"
                                :value="old('name', $user->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="mt-1 d-block w-100" type="email" name="email"
                                :value="old('email', $user->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="role" :value="__('Rol del Usuario')" />
                            <select id="role" name="role" class="form-select mt-1" required>
                                {{--
                                IMPORTANTE:
                                El Administrador Maestro (Master) NO debe poder ser cambiado de rol por nadie (protegido
                                por Gate).
                                --}}
                                @if ($user->role === 'admin-master')
                                    <option value="admin-master" selected>{{ __('Administrador Maestro (Fijo)') }}</option>
                                @else
                                    <option value="buyer" @selected(old('role', $user->role) == 'buyer')>{{ __('Comprador') }}
                                    </option>
                                    <option value="seller" @selected(old('role', $user->role) == 'seller')>
                                        {{ __('Vendedor') }}</option>
                                    {{-- Solo el Admin Master puede ascender a Admin Secundario --}}
                                    @can('is-admin-master')
                                        <option value="admin-secondary" @selected(old('role', $user->role) == 'admin-secondary')>
                                            {{ __('Administrador Secundario') }}</option>
                                    @endcan

                                @endif
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
                            <x-primary-button>
                                {{ __('Actualizar Usuario') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>