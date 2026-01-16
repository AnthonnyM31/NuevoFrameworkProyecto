<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark mb-0">
            {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="card shadow-lg border-0 overflow-hidden">
                <div class="card-body p-5">

                    {{-- MUESTRA MENSAJES FLASH DE ÉXITO O ERROR DE PAGO --}}
                    @if (session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            <strong class="fw-bold">¡Éxito!</strong> {{ session('success') }}
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger mb-4" role="alert">
                            <strong class="fw-bold">Error de Pago:</strong> {{ session('error') }}
                        </div>
                    @endif
                    {{-- FIN DE MENSAJES FLASH --}}

                    <div class="row gx-5">

                        <div class="col-md-8">
                            <h1 class="display-6 fw-bold text-dark mb-3">{{ $course->title }}</h1>
                            <p class="lead text-primary mb-4">{{ $course->header }}</p>

                            <h3 class="h5 fw-bold text-dark mb-2">Descripción Completa</h3>
                            <p class="text-muted mb-4">{{ $course->description }}</p>

                            <div class="bg-light p-4 rounded border">
                                <p class="small text-muted mb-2">
                                    🗓️ <strong>Fecha y Hora Tentativa:</strong> <span
                                        class="text-dark">{{ $course->scheduled_date->format('d/m/Y H:i') }}</span>
                                </p>
                                <p class="small text-muted mb-0">
                                    👨‍🏫 <strong>Impartido por:</strong> <span
                                        class="text-dark">{{ $course->user->name }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4 mt-4 mt-md-0">
                            <div class="sticky-top" style="top: 20px;">
                                <div class="p-4 bg-light border border-success rounded-3 shadow-sm text-center">
                                    <div class="mb-4">
                                        <span
                                            class="display-6 fw-bold text-success">${{ number_format($course->price, 2) }}</span>
                                        <p class="small text-muted">Precio de Inscripción</p>
                                    </div>

                                    {{-- Botón de Inscripción/Acceso a Contenido --}}
                                    @auth
                                        @if(auth()->user()->isBuyer())

                                            @php
                                                // Usamos la misma lógica que tu función isEnrolled
                                                $isEnrolled = $course->isEnrolled(Auth::id());
                                            @endphp

                                            {{-- 1. Si está inscrito: Muestra botón de ACCESO --}}
                                            @if ($isEnrolled)
                                                <a href="{{ route('courses.content', $course) }}"
                                                    class="btn btn-success w-100 py-3 fw-bold shadow-sm">
                                                    ✅ ACCEDER AL CONTENIDO
                                                </a>
                                            @else
                                                {{-- 2. Si NO está inscrito: Muestra el botón para ir a la Pasarela de Pago --}}
                                                <a href="{{ route('payment.checkout', $course) }}"
                                                    class="btn btn-primary w-100 py-3 fw-bold shadow-sm">
                                                    💳 PAGAR Y SUSCRIBIRME (${{ number_format($course->price, 2) }})
                                                </a>
                                                <p class="mt-2 small text-muted">Acceso inmediato tras el pago simulado.</p>
                                            @endif

                                            {{-- El mensaje 'info' que envía el controlador si ya está matriculado --}}
                                            @if (session('info'))
                                                <div class="alert alert-info mt-3 py-2 small">{{ session('info') }}</div>
                                            @endif

                                        @else
                                            <p class="small text-danger">Solo los compradores pueden inscribirse.</p>
                                        @endif
                                    @else
                                        {{-- Usuario no autenticado --}}
                                        <p class="small text-muted mb-3">Debes iniciar sesión para inscribirte.</p>
                                        <a href="{{ route('login') }}" class="btn btn-primary w-100">
                                            {{ __('Iniciar Sesión') }}
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>