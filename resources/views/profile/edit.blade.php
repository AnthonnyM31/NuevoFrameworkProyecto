<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold mb-0">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container space-y-4">

            <!-- Pestañas de Navegación -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <!-- Pestaña 1: Información General -->
                        <li class="nav-item">
                            <a href="{{ route('profile.edit') }}"
                                class="nav-link @if(Route::currentRouteName() === 'profile.edit') active fw-bold @else text-muted @endif">
                                {{ __('Información General') }}
                            </a>
                        </li>
                        <!-- Pestaña 2: Métodos de Pago -->
                        <li class="nav-item">
                            <a href="#payment-methods" class="nav-link text-muted">
                                {{ __('Métodos de Pago') }}
                            </a>
                        </li>
                        <!-- Pestaña 3: Historial de Compras -->
                        <li class="nav-item">
                            <a href="{{ route('profile.payments') }}"
                                class="nav-link @if(Route::currentRouteName() === 'profile.payments') active fw-bold @else text-muted @endif">
                                {{ __('Historial de Compras') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>


            <!-- Contenido de las Formas de Perfil -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="col-lg-8 mx-auto">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="col-lg-8 mx-auto">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- NUEVA SECCIÓN: Métodos de Pago -->
            <div id="payment-methods" class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="col-lg-8 mx-auto">
                        @include('profile.partials.payment-methods-form', ['paymentMethods' => $user->paymentMethods])
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="col-lg-8 mx-auto">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>