<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo API React</title>

    <!-- Scripts y Estilos (Vite) -->
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="container mx-auto px-4 py-8">
        <header class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800">Demo: Consumo de API con React</h1>
            <p class="text-gray-600 mt-2">Esta vista utiliza un componente de React independiente del resto del sistema.
            </p>
            <a href="{{ route('courses.index') }}" class="text-blue-500 hover:underline mt-4 inline-block">← Volver al
                Sistema Principal</a>
        </header>

        <!-- Contenedor donde se montará React -->
        <div id="react-app"></div>

    </div>

</body>

</html>