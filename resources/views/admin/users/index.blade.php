<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark mb-0">
            {{ __('Panel de Administración | Gestión de Usuarios') }}
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

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="h5 fw-bold text-dark mb-0">{{ __('Usuarios del Sistema') }}</h3>
                        <a href="{{ route('admin.users.create') }}">
                            <x-primary-button>{{ __('+ Crear Nuevo Administrador') }}</x-primary-button>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="text-uppercase text-muted small ps-4">Nombre</th>
                                    <th scope="col" class="text-uppercase text-muted small">Email</th>
                                    <th scope="col" class="text-uppercase text-muted small">Rol</th>
                                    <th scope="col" class="text-uppercase text-muted small">Cursos / Inscripciones</th>
                                    <th scope="col" class="text-uppercase text-muted small text-end pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="fw-bold text-dark ps-4">{{ $user->name }}</td>
                                        <td class="text-muted">{{ $user->email }}</td>
                                        <td>
                                            <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary">
                                                {{ $user->role }}
                                            </span>
                                        </td>
                                        <td class="text-muted small">
                                            V: {{ $user->courses->count() }} | C: {{ $user->enrollments->count() }}
                                        </td>
                                        <td class="text-end pe-4">
                                            {{-- El Gate verifica si el usuario autenticado puede tocar al usuario objetivo
                                            --}}
                                            @can('manage-user', $user)
                                                <a href="{{ route('admin.users.edit', $user) }}"
                                                    class="btn btn-sm btn-link text-decoration-none fw-bold me-2">Editar</a>

                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('¿Eliminar a {{ $user->name }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-link text-danger text-decoration-none fw-bold">Eliminar</button>
                                                </form>
                                            @else
                                                <span class="text-muted small ms-3">{{ __('No permitido') }}</span>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>