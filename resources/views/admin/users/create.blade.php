<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark mb-0">
            {{ __('Crear Administrador Secundario') }}
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

                    <form method="POST" action="{{ route('admin.users.store-admin') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="mt-1 d-block w-100" type="text" name="name"
                                :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mb-3">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="mt-1 d-block w-100" type="email" name="email"
                                :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="mt-1 d-block w-100" type="password" name="password"
                                required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" class="mt-1 d-block w-100" type="password"
                                name="password_confirmation" required />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
                            <x-primary-button>
                                {{ __('Crear Admin Secundario') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>