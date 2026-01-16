<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark mb-0">
            {{ __('Agendar Nuevo Curso') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <form method="POST" action="{{ route('seller.courses.store') }}">
                        @csrf

                        <div class="mb-3">
                            <x-input-label for="title" :value="__('Título del Curso')" />
                            <x-text-input id="title" class="mt-1 d-block w-100" type="text" name="title"
                                :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <x-input-label for="header" :value="__('Encabezado/Subtítulo')" />
                            <x-text-input id="header" class="mt-1 d-block w-100" type="text" name="header"
                                :value="old('header')" required />
                            <x-input-error :messages="$errors->get('header')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <x-input-label for="scheduled_date" :value="__('Fecha y Hora Tentativa de la Clase')" />
                            <x-text-input id="scheduled_date" class="mt-1 d-block w-100" type="datetime-local"
                                name="scheduled_date" :value="old('scheduled_date')" required />
                            <x-input-error :messages="$errors->get('scheduled_date')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <x-input-label for="price" :value="__('Precio (USD)')" />
                            <div class="input-group mt-1">
                                <span class="input-group-text">$</span>
                                <x-text-input id="price" class="d-block form-control" type="number" step="0.01"
                                    name="price" :value="old('price', 0.00)" required />
                            </div>
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Descripción del Curso')" />
                            <textarea id="description" name="description" rows="4" class="form-control mt-1"
                                required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>


                        <div class="d-flex justify-content-end">
                            <a href="{{ route('seller.courses.index') }}"
                                class="btn btn-outline-secondary me-2">Cancel</a>
                            <x-primary-button>
                                {{ __('Agendar Curso') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>