<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NexusV - Plataforma de Cursos</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">NexusV</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Iniciar Sesión</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn btn-primary ms-lg-3">Registrarse</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="bg-primary text-white text-center py-5">
        <div class="container py-5">
            <h1 class="display-4 fw-bold mb-3">Bienvenido a NexusV</h1>
            <p class="lead mb-4">La plataforma definitiva para aprender y enseñar cursos en línea.</p>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4 gap-3">Comenzar Ahora</a>
            @endif
            <a href="{{ route('courses.index') }}" class="btn btn-outline-light btn-lg px-4 gap-3 ms-2">Explorar
                Cursos</a>
        </div>
    </header>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container px-4 py-5" id="featured-3">
            <h2 class="pb-2 border-bottom text-center">¿Por qué elegir NexusV?</h2>
            <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
                <div class="col">
                    <div class="p-5 bg-white rounded-3 shadow-sm h-100">
                        <div class="feature-icon bg-primary bg-gradient text-white rounded-3 mb-4 p-3 d-inline-block">
                            <svg class="bi" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                <path fill-rule="evenodd"
                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                            </svg>
                        </div>
                        <h2>Instructores Expertos</h2>
                        <p>Aprende de los mejores profesionales en la industria con cursos diseñados para el éxito.</p>
                    </div>
                </div>
                <div class="col">
                    <div class="p-5 bg-white rounded-3 shadow-sm h-100">
                        <div class="feature-icon bg-primary bg-gradient text-white rounded-3 mb-4 p-3 d-inline-block">
                            <svg class="bi" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z" />
                            </svg>
                        </div>
                        <h2>Certificación</h2>
                        <p>Obtén certificados verificables al completar tus cursos y mejora tu currículum.</p>
                    </div>
                </div>
                <div class="col">
                    <div class="p-5 bg-white rounded-3 shadow-sm h-100">
                        <div class="feature-icon bg-primary bg-gradient text-white rounded-3 mb-4 p-3 d-inline-block">
                            <svg class="bi" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                            </svg>
                        </div>
                        <h2>Acceso Seguro</h2>
                        <p>Plataforma segura y confiable para gestionar tus pagos y progreso de aprendizaje.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-3 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Inicio</a></li>
            <li class="nav-item"><a href="{{ route('courses.index') }}" class="nav-link px-2 text-muted">Cursos</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Precios</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Acerca de</a></li>
        </ul>
        <p class="text-center text-muted">© {{ date('Y') }} NexusV, Inc</p>
    </footer>
</body>

</html>