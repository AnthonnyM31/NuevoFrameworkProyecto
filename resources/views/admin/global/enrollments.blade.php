<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark mb-0">
            {{ __('Panel Admin | Inscripciones Globales') }}
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
                    <a class="nav-link text-muted"
                        href="{{ route('admin.courses.index') }}">{{ __('Cursos Globales') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active fw-bold"
                        href="{{ route('admin.enrollments.index') }}">{{ __('Inscripciones Globales') }}</a>
                </li>
            </ul>
            {{-- FIN PESTAÑAS --}}

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="h5 fw-bold text-dark mb-4">{{ __('Todas las Inscripciones del Sistema') }}</h3>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="text-uppercase text-muted small ps-4">ID Inscripción</th>
                                    <th scope="col" class="text-uppercase text-muted small">Curso</th>
                                    <th scope="col" class="text-uppercase text-muted small">Comprador</th>
                                    <th scope="col" class="text-uppercase text-muted small">Fecha</th>
                                    <th scope="col" class="text-uppercase text-muted small text-end pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @foreach ($enrollments as $enrollment)
                                    <tr>
                                        <td class="text-muted ps-4">{{ $enrollment->id }}</td>
                                        <td class="fw-bold text-dark">{{ $enrollment->course->title }}</td>
                                        <td class="text-muted">{{ $enrollment->user->name }}</td>
                                        <td class="text-muted">{{ $enrollment->created_at->format('d M Y') }}</td>
                                        <td class="text-end pe-4">
                                            {{-- FORMULARIO DELETE GLOBAL --}}
                                            <form action="{{ route('admin.enrollments.destroy', $enrollment) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('¿Eliminar esta inscripción ID {{ $enrollment->id }}? Esta acción es irreversible.');">
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
                    <div class="mt-4">{{ $enrollments->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>