<section>
    <header>
        <h2 class="h5 text-dark">
            {{ __('Métodos de Pago Guardados') }}
        </h2>
        <p class="text-muted small">
            {{ __('Administra tus tarjetas guardadas para compras rápidas.') }}
        </p>
    </header>

    @if ($paymentMethods->count())
        <div class="mt-4 d-flex flex-column gap-3">
            @foreach ($paymentMethods as $method)
                <div
                    class="d-flex align-items-center justify-content-between p-3 border rounded {{ $method->is_default ? 'bg-light border-primary shadow-sm' : 'bg-white' }}">
                    <!-- Detalles de la Tarjeta -->
                    <div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="bi me-3 {{ $method->is_default ? 'text-primary' : 'text-secondary' }}" width="24" height="24"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <p class="mb-0 fw-bold text-dark">
                                {{ $method->brand }} terminada en {{ $method->last_four }}
                                @if ($method->is_default)
                                    <span class="badge bg-primary ms-2">{{ __('Predeterminada') }}</span>
                                @endif
                            </p>
                            <p class="mb-0 small text-muted">
                                Expira: {{ $method->expiration_date }} | Titular: {{ $method->card_holder_name }}
                            </p>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="d-flex align-items-center gap-2">
                        @unless ($method->is_default)
                            <form method="POST" action="{{ route('payment-methods.set-default', $method) }}">
                                @csrf
                                @method('PATCH')
                                <x-primary-button class="btn-sm">
                                    {{ __('Establecer como Predeterminada') }}
                                </x-primary-button>
                            </form>
                        @endunless

                        <form method="POST" action="{{ route('payment-methods.destroy', $method) }}"
                            onsubmit="return confirm('¿Estás seguro de que quieres eliminar este método de pago?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-danger text-decoration-none btn-sm">
                                {{ __('Eliminar') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="mt-3 small text-muted">{{ __('No tienes métodos de pago guardados.') }}</p>
    @endif

    <div class="mt-5 pt-4 border-top">
        <h3 class="h6 fw-bold text-dark mb-3">{{ __('Agregar Nuevo Método de Pago') }}</h3>

        <!-- Formulario para agregar una nueva tarjeta -->
        <form method="post" action="{{ route('payment-methods.store') }}" class="mt-3">
            @csrf

            <div class="mb-3">
                <x-input-label for="card_holder_name" :value="__('Nombre del Titular')" />
                <x-text-input id="card_holder_name" name="card_holder_name" type="text" class="mt-1 d-block w-100"
                    required autocomplete="cc-name" />
                <x-input-error class="mt-2" :messages="$errors->get('card_holder_name')" />
            </div>

            <div class="mb-3">
                <x-input-label for="card_number" :value="__('Número de Tarjeta')" />
                <x-text-input id="card_number" name="card_number" type="text" class="mt-1 d-block w-100"
                    pattern="\d{16}" maxlength="16" required placeholder="XXXX XXXX XXXX XXXX" inputmode="numeric" />
                <x-input-error class="mt-2" :messages="$errors->get('card_number')" />
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <x-input-label for="expiry_month" :value="__('Mes Exp.')" />
                    <x-text-input id="expiry_month" name="expiry_month" type="number" class="mt-1 d-block w-100"
                        required min="1" max="12" placeholder="MM" />
                    <x-input-error class="mt-2" :messages="$errors->get('expiry_month')" />
                </div>
                <div class="col-md-4">
                    <x-input-label for="expiry_year" :value="__('Año Exp.')" />
                    <x-text-input id="expiry_year" name="expiry_year" type="number" class="mt-1 d-block w-100" required
                        min="{{ date('Y') }}" max="{{ date('Y') + 10 }}" placeholder="YYYY" />
                    <x-input-error class="mt-2" :messages="$errors->get('expiry_year')" />
                </div>
                <div class="col-md-4">
                    <x-input-label for="cvc" :value="__('CVC')" />
                    <x-text-input id="cvc" name="cvc" type="text" class="mt-1 d-block w-100" pattern="\d{3}"
                        maxlength="3" required placeholder="CVC" inputmode="numeric" />
                    <x-input-error class="mt-2" :messages="$errors->get('cvc')" />
                </div>
            </div>

            <div class="mb-3 form-check">
                <input id="is_default" name="is_default" type="checkbox" value="1" checked class="form-check-input">
                <label for="is_default" class="form-check-label">
                    {{ __('Establecer como tarjeta predeterminada') }}
                </label>
            </div>

            <div class="d-flex align-items-center gap-3">
                <x-primary-button>{{ __('Guardar Tarjeta') }}</x-primary-button>

                @if (session('status') === 'Método de pago agregado exitosamente.')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="small text-muted mb-0">{{ __('Guardado.') }}</p>
                @endif
            </div>
        </form>
    </div>
</section>