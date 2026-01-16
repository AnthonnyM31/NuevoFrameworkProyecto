<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark mb-0">
            {{ __('Panel de Gestión de Cursos') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-end mb-4">
                        <a href="{{ route('seller.courses.create') }}">
                            <x-primary-button>
                                {{ __('+ Agendar Nuevo Curso') }}
                            </x-primary-button>
                        </a>
                    </div>

                    {{-- TABLA DE LISTADO DE CURSOS DEL VENDEDOR --}}
                    @if ($courses->isEmpty())
                        <div class="text-center py-5">
                            <p class="text-muted mb-0">No tienes cursos. Haz clic arriba para empezar a agendar.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="text-uppercase text-muted small ps-4">Título</th>
                                        <th scope="col" class="text-uppercase text-muted small">Fecha</th>
                                        <th scope="col" class="text-uppercase text-muted small">Estado</th>
                                        <th scope="col" class="text-uppercase text-muted small text-end pe-4"><span
                                                class="visually-hidden">Acciones</span></th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0">
                                    @foreach ($courses as $course)
                                        <tr>
                                            <td class="fw-bold text-dark ps-4">{{ $course->title }}</td>
                                            <td class="text-muted">{{ $course->scheduled_date->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill {{ $course->is_published ? 'bg-success' : 'bg-warning text-dark' }}">
                                                    {{ $course->is_published ? 'Publicado' : 'Borrador' }}
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="{{ route('seller.courses.edit', $course) }}"
                                                    class="btn btn-sm btn-link text-decoration-none fw-bold">Editar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>