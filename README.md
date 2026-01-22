# NexusV - Refactorización y API (Proyecto Ingeniería Web)

Este proyecto ha sido actualizado para incorporar mejores prácticas de desarrollo (SOLID), una API RESTful robusta y una integración con React para demostrar el consumo desacoplado de datos.

## 🚀 Resumen de Cambios

### 1. Refactorización y Buenas Prácticas (SOLID)
El código base original (MVC) ha sido refactorizado para adherirse mejor a los principios SOLID, específicamente el **Principio de Responsabilidad Única (SRP)**.

*   **PaymentService**: Se extrajo toda la lógica de negocio relacionada con el procesamiento de pagos, simulación de pasarela y registro de matrículas desde el controlador hacia un servicio dedicado (`App\Services\PaymentService`).
*   **PaymentController**: Ahora actúa como un controlador "delgado" que solo gestiona la entrada HTTP y delega la lógica al servicio.
*   **DashboardController**: Se eliminó la lógica de redirección y carga de datos que residía en el archivo de rutas `web.php` (Closure), moviéndola a un controlador limpio y mantenible (`App\Http\Controllers\DashboardController`).

### 2. API RESTful con Autenticación
Se implementó una API JSON completa para permitir que clientes externos (como aplicaciones móviles o SPAs) consuman los datos del sistema de manera segura.

*   **Tecnología**: Laravel Sanctum para autenticación basada en tokens.
*   **Endpoints Clave**:
    *   `POST /api/login`: Autenticación de usuarios y generación de Tokens.
    *   `POST /api/logout`: Revocación de tokens.
    *   `GET /api/me`: Información del perfil del usuario y sus inscripciones.
    *   `GET /api/courses`: Listado público de cursos disponibles.
    *   `GET /api/courses/{id}`: Detalles completos de un curso.

### 3. Integración Frontend (React)
Para cumplir con el requisito de consumir la API desde un framework JavaScript moderno, se integró **React** dentro del ecosistema Blade existente.

*   **Componente React**: `ApiCourseList.jsx` es un componente funcional que gestiona:
    *   Login asíncrono contra la API.
    *   Almacenamiento seguro del Token en `localStorage`.
    *   Listado dinámico de cursos obtenidos desde `/api/courses`.
*   **Integración**: Configuración de `Vite` con `@vitejs/plugin-react` para compilar JSX junto con los assets de Laravel.
*   **Demo**: Accesible en la ruta `/api-demo`.

---

## 🛠️ Guía de Instalación y Uso

### Prerrequisitos
*   PHP 8.2+
*   Composer
*   Node.js & NPM
*   Base de datos (SQLite por defecto o MySQL)

### Pasos
1.  **Clonar el repositorio**:
    ```bash
    git clone https://github.com/AnthonnyM31/NuevoFrameworkProyecto.git
    cd NuevoFrameworkProyecto
    ```

2.  **Instalar dependencias Backend**:
    ```bash
    composer install
    ```

3.  **Configurar entorno**:
    ```bash
    cp .env.example .env
    php artisan key:generate
    touch database/database.sqlite # Si usas SQLite
    php artisan migrate --seed
    ```

4.  **Instalar dependencias Frontend (React + Vite)**:
    ```bash
    npm install
    npm run dev
    ```

5.  **Ejecutar servidor**:
    ```bash
    php artisan serve
    ```

### 🧪 Cómo probar las nuevas funcionalidades

1.  **Probar la API y React**:
    *   Ve a `http://localhost:8000/api-demo` en tu navegador.
    *   Verás una interfaz construida 100% con React.
    *   Ingresa un usuario válido (ej: `admin@example.com` / `password`).
    *   Al iniciar sesión, React obtendrá un Token de la API y cargará la lista de cursos sin recargar la página.

2.  **Verificar Refactorización (Pagos)**:
    *   Navega por el flujo normal de compra de un curso.
    *   El proceso es transparente para el usuario final, pero internamente ahora utiliza `PaymentService`, garantizando un código más limpio y testeable.

---

**Desarrollado para la asignatura de Ingeniería Web - Séptimo Semestre.**
