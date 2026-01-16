<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark mb-0">
            {{ __('Contenido del Curso: ') . $course->title }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">

                    {{-- Mensajes de feedback --}}
                    @if (session('success'))
                        <div class="alert alert-success mb-4">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
                    @endif

                    {{-- CERTIFICADO --}}
                    @if ($progressPercent == 100)
                        <div class="alert alert-primary d-flex flex-column flex-md-row justify-content-between align-items-center mb-4"
                            role="alert">
                            <div class="mb-3 mb-md-0">
                                <h4 class="alert-heading fw-bold py-2">{{ __('¡Felicidades! Curso Completado.') }}</h4>
                                <p class="mb-0">
                                    {{ __('Has completado todas las lecciones. Obtén tu certificado ahora mismo.') }}</p>
                            </div>

                            <a href="{{ route('courses.certify', $course) }}" class="btn btn-primary fw-bold">
                                {{ __('Generar Certificado') }}
                            </a>
                        </div>
                    @endif

                    {{-- Encabezado de Progreso --}}
                    <h3 class="h4 fw-bold mb-3">Progreso General</h3>
                    <div class="mb-5">
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                style="width: {{ $progressPercent }}%;" aria-valuenow="{{ $progressPercent }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="h4 fw-bold text-primary mb-0">{{ $progressPercent }}% Completado</span>
                            <span class="text-muted small">{{ $completedModules }} de {{ $totalModules }} lecciones
                                vistas.</span>
                        </div>
                    </div>

                    <h3 class="h4 fw-bold mb-4 border-bottom pb-2">Temario del Curso</h3>

                    {{-- LISTA DE MÓDULOS --}}
                    <div class="d-flex flex-column gap-3">
                        @forelse ($modules as $module)
                            @php
                                $isCompleted = $module->progress->isNotEmpty() && $module->progress->first()->is_completed;
                            @endphp

                            {{-- Contenedor del Módulo --}}
                            <div
                                class="card border {{ $isCompleted ? 'border-success bg-light' : 'border-light bg-white' }} shadow-sm">

                                {{-- Cabecera del Módulo (Título y Estado) --}}
                                <div
                                    class="card-header bg-transparent border-bottom-0 d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge bg-dark rounded-pill">{{ $module->sequence_order }}</span>
                                        <h4 class="h6 fw-bold mb-0 {{ $isCompleted ? 'text-success' : 'text-dark' }}">
                                            {{ $module->title }}
                                        </h4>
                                        @if ($isCompleted)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">✅
                                                Visto</span>
                                        @endif
                                    </div>

                                    {{-- Botón Marcar como Completado --}}
                                    @if (!$isCompleted)
                                        <form method="POST" action="{{ route('progress.store', $module) }}">
                                            @csrf
                                            <x-primary-button class="btn-sm">
                                                {{ __('Marcar como Visto') }}
                                            </x-primary-button>
                                        </form>
                                    @endif
                                </div>

                                {{-- CUERPO DEL CONTENIDO (Aquí es donde ocurre la magia) --}}
                                <div class="card-body p-4 bg-white border-top">

                                    {{-- CASO 1: VIDEO --}}
                                    @if($module->content_type === 'video')
                                        <div class="col-lg-10 mx-auto">
                                            <div class="ratio ratio-16x9 shadow rounded overflow-hidden bg-black">
                                                {{-- Usamos asset('storage/...') para acceder al archivo --}}
                                                <video controls controlsList="nodownload">
                                                    <source src="{{ asset('storage/' . $module->content_path) }}"
                                                        type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                            <p class="text-muted small mt-2 text-center">Reproduce el video de la lección.</p>
                                        </div>

                                        {{-- CASO 2: DOCUMENTO --}}
                                    @elseif($module->content_type === 'document')
                                        <div class="text-center p-4 border border-2 border-dashed rounded bg-light">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                                class="bi bi-file-earmark-text text-secondary mb-2" viewBox="0 0 16 16">
                                                <path
                                                    d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 2a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5z" />
                                                <path
                                                    d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                                            </svg>
                                            <p class="small text-muted mb-3">Material de lectura disponible</p>
                                            <a href="{{ asset('storage/' . $module->content_path) }}" target="_blank"
                                                class="btn btn-primary btn-sm">
                                                📄 Descargar / Ver Documento
                                            </a>
                                        </div>

                                        {{-- CASO 3: LINK --}}
                                    @elseif($module->content_type === 'link')
                                        <div class="alert alert-info d-flex align-items-center" role="alert">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                                class="bi bi-link-45deg me-2" viewBox="0 0 16 16">
                                                <path
                                                    d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z" />
                                                <path
                                                    d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243L6.586 4.672z" />
                                            </svg>
                                            <div>
                                                Esta lección es un recurso externo:
                                                <a href="{{ $module->content_url }}" target="_blank" class="alert-link">
                                                    {{ $module->content_url }}
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 bg-light rounded border border-dashed">
                                <p class="text-muted mb-0">Este curso aún no tiene lecciones cargadas.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>