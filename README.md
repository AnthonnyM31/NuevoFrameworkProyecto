# Proyecto Migrado: NexusV (Tailwind a Bootstrap 5)

Este proyecto ha sido sometido a una migración completa de su framework de estilos frontend, pasando de **Tailwind CSS** a **Bootstrap 5**, manteniendo intacta la lógica de negocio y el backend en Laravel.

## 🚀 Resumen del Procedimiento de Migración

El objetivo principal fue reemplazar la capa visual sin afectar la funcionalidad existente. A continuación se detallan los pasos realizados:

### 1. Limpieza y Configuración Inicial
- **Eliminación de Tailwind**: Se desinstalaron los paquetes `tailwindcss`, `postcss` y `autoprefixer`. Se eliminaron los archivos de configuración asociados (`tailwind.config.js`, `postcss.config.js`).
- **Instalación de Bootstrap**: Se instaló `bootstrap` (versión 5.3) y `@popperjs/core` vía NPM. También se instaló `sass` para el preprocesamiento de estilos.
- **Configuración de Vite**: Se actualizó `vite.config.js` para procesar archivos SASS (`app.scss`) en lugar de CSS plano, y se configuró la importación de JavaScript de Bootstrap.

### 2. Migración de Layouts (Estructura Base)
- **App Layout**: Se reemplazaron las clases de utilidad de Tailwind por los contenedores y Grid system de Bootstrap (`container`, `row`, `col`).
- **Navigation**: Se reescribió la barra de navegación utilizando el componente `Navbar` de Bootstrap, eliminando la dependencia de Alpine.js para los menús desplegables básicos (aunque Alpine se mantuvo para otras interacciones).
- **Guest Layout**: Se ajustaron las vistas de autenticación para usar Flexbox utilities de Bootstrap para el centrado y tarjetas (`card`) para los formularios.

### 3. Migración de Vistas (Blade Views)
Se rediseñaron todas las vistas del sistema para adoptar la estética "Premium" de Bootstrap:

- **Autenticación**: Login, Registro, Recuperación de contraseña, etc.
- **Módulos Principales**:
  - **Bienvenida (Welcome)**: Nueva Landing Page con componentes Hero y Features.
  - **Dashboard**: Panel principal con tarjetas informativas.
  - **Perfil**: Formularios de edición de perfil, cambio de contraseña y gestión de tarjetas de crédito (diseño de pestañas y modales).
- **Cursos (Público)**:
  - **Catálogo**: Grid responsivo de tarjetas de cursos.
  - **Detalle**: Vista detallada con sidebar "sticky" para precios y acciones.
  - **Reproductor de Contenido**: Interfaz para consumir videos y documentos con barras de progreso.
- **Gestión (Vendedor y Admin)**:
  - **Tablas**: Se implementaron tablas estilizadas (`table-hover`) para la gestión de usuarios, cursos e inscripciones.
  - **Formularios**: Se estandarizaron todos los `input`, `select` y `button` con las clases `form-control`, `form-select` y `btn`.

### 4. Componentes Globales
Se actualizaron los componentes Blade reutilizables (`x-primary-button`, `x-text-input`, `x-modal`, etc.) para que rendericen internamente clases de Bootstrap, asegurando consistencia en todo el sitio.

## 🛠️ Cómo ejecutar este proyecto

1.  **Clonar el repositorio**:
    ```bash
    git clone https://github.com/AnthonnyM31/NuevoFrameworkProyecto.git
    cd NuevoFrameworkProyecto
    ```

2.  **Instalar dependencias de PHP**:
    ```bash
    composer install
    ```

3.  **Instalar dependencias de Node (Frontend)**:
    ```bash
    npm install
    npm run build
    ```

4.  **Configurar entorno**:
    - Duplicar `.env.example` a `.env` y configurar base de datos.
    - Ejecutar migraciones: `php artisan migrate`.

5.  **Iniciar servidor**:
    ```bash
    php artisan serve
    ```

El proyecto ahora cuenta con una interfaz robusta, responsiva y mantenible basada en el estándar de la industria Bootstrap 5.

## 👥 Usuarios por Defecto (Seeders)

Para facilitar las pruebas, se han creado los siguientes usuarios por defecto en la base de datos:

| Rol | Nombre | Email | Contraseña |
| :--- | :--- | :--- | :--- |
| 👑 **Admin Maestro** | Admin Maestro | `admin@nexusv.com` | `password123` |
| 💼 **Vendedor** | Vendedor Demo | `seller@test.com` | `password123` |
| 🛒 **Comprador** | Comprador Demo | `buyer@test.com` | `password123` |
