<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark mb-0">
            {{ __('Panel Admin | Cursos Globales') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            {{-- AÑADIDO: Pestañas de Navegación del Administrador --}}
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link text-muted" href="{{ route('admin.users.index') }}">{{ __('Usuarios') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active fw-bold"
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
                    <h3 class="h5 fw-bold text-dark mb-4">{{ __('Todos los Cursos Creados') }}</h3>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="text-uppercase text-muted small ps-4">ID</th>
                                    <th scope="col" class="text-uppercase text-muted small">Título</th>
                                    <th scope="col" class="text-uppercase text-muted small">Vendedor</th>
                                    <th scope="col" class="text-uppercase text-muted small">Estado</th>
                                    <th scope="col" class="text-uppercase text-muted small text-end pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @foreach ($courses as $course)
                                    <tr>
                                        <td class="text-muted ps-4">{{ $course->id }}</td>
                                        <td class="fw-bold text-dark">{{ $course->title }}</td>
                                        <td class="text-muted">{{ $course->user->name }}</td>
                                        <td>
                                            <span
                                                class="badge rounded-pill {{ $course->is_published ? 'bg-success' : 'bg-warning text-dark' }}">
                                                {{ $course->is_published ? 'Publicado' : 'Borrador' }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            {{-- Enlace para Editar (usa la ruta del vendedor) --}}
                                            <a href="{{ route('seller.courses.edit', $course) }}"
                                                class="btn btn-sm btn-link text-decoration-none fw-bold me-2">Editar</a>

                                            {{-- FORMULARIO DELETE GLOBAL (admin.courses.destroy) --}}
                                            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('ATENCIÓN: Eliminar el curso {{ $course->title }} eliminará TODAS las inscripciones asociadas. ¿Confirmar?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-link text-danger text-decoration-none fw-bold">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $courses->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>