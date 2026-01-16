<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm border-bottom">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <x-application-logo class="d-inline-block align-text-top"
                style="height: 2.25rem; width: auto; fill: currentColor;" />
        </a>

        <!-- Hamburger -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold text-primary' : '' }}"
                        href="{{ route('dashboard') }}">
                        {{ __('Dashboard') }}
                    </a>
                </li>

                {{-- Enlace público de Cursos --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('courses.index') ? 'active fw-bold text-primary' : '' }}"
                        href="{{ route('courses.index') }}">
                        {{ __('Explorar Cursos') }}
                    </a>
                </li>

                {{-- ENLACE CONDICIONAL PARA VENDEDORES --}}
                @can('is-seller')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('seller/courses') ? 'active fw-bold text-primary' : '' }}"
                            href="/seller/courses">
                            {{ __('Gestión de Cursos') }}
                        </a>
                    </li>
                @endcan

                {{-- NUEVO: ENLACE CONDICIONAL PARA ADMINISTRADORES --}}
                @can('manage-system')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.index') ? 'active fw-bold text-primary' : '' }}"
                            href="{{ route('admin.users.index') }}">
                            {{ __('Panel Admin') }}
                        </a>
                    </li>
                @endcan
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @auth
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                {{ __('Profile') }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Log in') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>