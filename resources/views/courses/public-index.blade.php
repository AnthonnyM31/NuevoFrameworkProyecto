<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark mb-0">
            {{ __('Explorar Cursos Disponibles') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-body p-4">
                    {{-- Formulario de Búsqueda --}}
                    <form method="GET" action="{{ route('courses.index') }}" class="d-flex gap-3">
                        <x-text-input type="search" name="search" placeholder="Buscar por título o encabezado..." class="w-100" value="{{ request('search') }}" />
                        <x-primary-button type="submit">
                            {{ __('Buscar') }}
                        </x-primary-button>
                        @if(request('search'))
                            <a href="{{ route('courses.index') }}" class="btn btn-light border text-nowrap">{{ __('Limpiar') }}</a>
                        @endif
                    </form>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse ($courses as $course)
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0 hover-shadow transition">
                            <div class="card-body p-4">
                                <h3 class="h5 card-title fw-bold text-dark mb-2">{{ $course->title }}</h3>
                                <p class="card-subtitle text-primary small mb-3">{{ $course->header }}</p>
                                
                                <p class="card-text text-muted small mb-4" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">{{ $course->description }}</p>
                                
                                <div class="d-flex justify-content-between text-muted small mb-4 border-top pt-3">
                                    <span>🗓️ {{ $course->scheduled_date->format('d M Y H:i') }}</span>
                                    <span>👨‍🏫 {{ $course->user->name }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <span class="h5 fw-bold text-success mb-0">${{ number_format($course->price, 2) }}</span>
                                    
                                    {{-- Enlace a la vista de detalle/inscripción --}}
                                    <a href="{{ route('courses.show', $course) }}" class="btn btn-primary btn-sm">
                                        {{ __('Ver Detalles / Inscribirse') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                         <p class="text-center text-muted">No se encontraron cursos publicados o que coincidan con la búsqueda.</p>
                    </div>
                @endforelse
            </div>

            {{-- Paginación --}}
            <div class="mt-5">
                {{ $courses->links() }}
            </div>

        </div>
    </div>
</x-app-layout>

<style>
    .hover-shadow:hover {
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .transition {
        transition: box-shadow 0.3s ease-in-out;
    }
</style>