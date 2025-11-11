<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <div class="flex flex-col md:flex-row md:space-x-8">
                    
                    <div class="md:w-2/3">
                        <h1 class="text-3xl font-extrabold text-gray-900 mb-4">{{ $course->title }}</h1>
                        <p class="text-lg text-indigo-600 mb-6">{{ $course->header }}</p>
                        
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Descripción Completa</h3>
                        <p class="text-gray-700 leading-relaxed mb-6">{{ $course->description }}</p>
                        
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-600">
                                🗓️ **Fecha y Hora Tentativa:** <span class="font-medium text-gray-800">{{ $course->scheduled_date->format('d/m/Y H:i') }}</span>
                            </p>
                            <p class="text-sm text-gray-600 mt-2">
                                👨‍🏫 **Impartido por:** <span class="font-medium text-gray-800">{{ $course->user->name }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="md:w-1/3 mt-8 md:mt-0 sticky top-0">
                        <div class="p-6 bg-green-50 border-2 border-green-200 rounded-xl shadow-lg">
                            <div class="text-center mb-4">
                                <span class="text-3xl font-extrabold text-green-700">${{ number_format($course->price, 2) }}</span>
                                <p class="text-sm text-gray-500">Precio de Inscripción</p>
                            </div>

                            {{-- Botón de Inscripción --}}
                            @auth
                                @if(auth()->user()->isBuyer())
                                    
                                    {{-- Lógica: Comprobar si ya está inscrito --}}
                                    @if ($course->isEnrolled(Auth::id()))
                                        <p class="text-center text-md font-bold text-green-600 mt-4">✅ ¡Ya estás inscrito!</p>
                                    @else
                                        {{-- FORMULARIO CORREGIDO: Apunta a la ruta POST de inscripción --}}
                                        <form method="POST" action="{{ route('enroll.store', $course) }}" class="mt-4">
                                            @csrf
                                            <x-primary-button class="w-full justify-center bg-indigo-600 hover:bg-indigo-700">
                                                {{ __('INSCRIBIRSE AHORA') }}
                                            </x-primary-button>
                                        </form>
                                    @endif
                                    
                                    {{-- Mensajes de sesión --}}
                                    @if (session('success'))
                                        <div class="bg-green-100 text-green-700 p-2 mt-3 rounded">{{ session('success') }}</div>
                                    @elseif (session('info'))
                                        <div class="bg-blue-100 text-blue-700 p-2 mt-3 rounded">{{ session('info') }}</div>
                                    @endif

                                @else
                                    <p class="text-center text-sm text-red-500">Solo los compradores pueden inscribirse.</p>
                                @endif
                            @else
                                <p class="text-center text-sm text-gray-500 mb-4">Debes iniciar sesión para inscribirte.</p>
                                <a href="{{ route('login') }}" class="w-full inline-block text-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Iniciar Sesión') }}
                                </a>
                            @endauth
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>