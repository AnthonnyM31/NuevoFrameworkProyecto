```{=html}
<p align="center">
```
`<a href="https://laravel.com" target="_blank">`{=html}
`<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">`{=html}
`</a>`{=html}
```{=html}
</p>
```
```{=html}
<p align="center">
```
`<a href="https://github.com/AnthonnyM31/Proyecto_NexusV-V2">`{=html}
`<img src="https://img.shields.io/badge/Status-Complete-green" alt="Status">`{=html}
`</a>`{=html}
`<a href="https://packagist.org/packages/laravel/framework">`{=html}
`<img src="https://img.shields.io/badge/Framework-Laravel%2011%2B-red" alt="Laravel Version">`{=html}
`</a>`{=html}
`<a href="https://github.com/AnthonnyM31/Proyecto_NexusV-V2/blob/main/LICENSE">`{=html}
`<img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">`{=html}
`</a>`{=html}
```{=html}
</p>
```

------------------------------------------------------------------------

# 🚀 Proyecto NexusV-V2: Plataforma de Cursos con Control Total

**Implementación de Roles Jerárquicos y Gestión Global**

**NexusV-V2** es una plataforma de ingeniería web desarrollada en
**Laravel** que simula un sistema de **venta y gestión de cursos en
tiempo real**. Su arquitectura se basa en roles diferenciados:
**Administrador Maestro/Secundario, Vendedor** y **Comprador**.

------------------------------------------------------------------------

## 📚 Índice

1.  [🔑 Roles y Jerarquía](#-roles-y-jerarquía)\
2.  [💡 Lecciones Aprendidas](#-lecciones-aprendidas)\
3.  [⚙️ Instalación Local](#️-instalación-local)\
4.  [🧪 Flujo de Pruebas](#-flujo-de-pruebas)\
5.  [🌎 Despliegue y Repositorio](#-despliegue-y-repositorio)

------------------------------------------------------------------------

## 🔑 Roles y Jerarquía

El proyecto implementa un sistema de control de acceso avanzado mediante
Gates de Laravel:

  -----------------------------------------------------------------------
  Rol                     Función                 Nivel de Acceso
  ----------------------- ----------------------- -----------------------
  **Administrador         **Control Total.**      **Máximo** (Inmune a
  Maestro**               Puede crear otros       Admins Secundarios)
                          Admins, ver/modificar   
                          *todos* los datos, y    
                          eliminar *cualquier*    
                          recurso/usuario.        

  **Administrador         Gestión diaria de       **Alto** (Bloqueado
  Secundario**            usuarios, cursos e      para modificar al Admin
                          inscripciones.          Maestro)

  **Vendedor**            Crea y publica cursos.  **Limitado**

  **Comprador**           Se inscribe y visualiza **Limitado**
                          cursos.                 
  -----------------------------------------------------------------------

------------------------------------------------------------------------

## 💡 Lecciones Aprendidas

Durante el desarrollo se presentaron desafíos críticos relacionados con
la estabilidad del entorno y la inestabilidad de las clases de Breeze,
solucionados de la siguiente manera:

-   **Errores Cíclicos y Clases Faltantes:** Controladores esenciales de
    Breeze (`AuthenticatedSessionController`, `ProfileController`) no se
    generaron correctamente, lo cual se resolvió con la creación manual
    de archivos y limpieza profunda.
-   **Error Crítico `403`:** El Administrador Maestro era bloqueado al
    editar cursos de un vendedor porque el `Seller/CourseController` no
    tenía una **excepción** en la lógica de propiedad
    (`$course->user_id === Auth::id()`). Se solucionó añadiendo la
    verificación `Auth::user()->isMasterAdmin()` para anular la
    restricción.
-   **Corrupción de Base de Datos:** La tabla **`enrollments`** se
    generó sin las llaves foráneas (`course_id`), requiriendo el uso de
    `php artisan migrate:fresh` para restaurar la integridad del
    esquema.
-   **Inestabilidad de Rutas:** Se tuvo que **eliminar el uso de aliases
    de rutas** (`route('seller.courses.index')`) en las vistas para usar
    la URL directa (`/seller/courses`) para mejorar la estabilidad en el
    entorno Windows.

------------------------------------------------------------------------

## ⚙️ Instalación Local

Esta guía asume que tienes instalados **PHP (8.2+), Composer, y Node.js
(con NPM)**.

### 🔹 Paso 1: Clonar e Instalar Dependencias

``` bash
git clone https://github.com/AnthonnyM31/Proyecto_NexusV-V2.git
cd Proyecto_NexusV-V2

copy .env.example .env
php artisan key:generate

composer install
npm install
```

### 🔹 Paso 2: Configurar, Migrar y Sembrar Administrador

Crear la base de datos y la cuenta de administrador Maestro inicial.

``` bash
touch database/database.sqlite
php artisan migrate
php artisan db:seed --class=AdminSeeder
```

### 🔹 Paso 3: Ejecutar la Aplicación

``` bash
php artisan serve
npm run dev
```

URL local: http://127.0.0.1:8000

------------------------------------------------------------------------

## 🧪 Flujo de Pruebas Funcionales

### 🔸 Administrador Maestro

-   Inicia sesión con admin@nexusv.com / password123.
-   Verifica acceso total a usuarios y cursos globales.
-   Confirma que puedes editar/eliminar cursos de cualquier vendedor.

### 🔸 Vendedor / Comprador

-   Vendedor: publica un curso.
-   Comprador: se inscribe y verifica sus cursos.

------------------------------------------------------------------------

## 🌎 Despliegue y Repositorio

El proyecto está listo para Render con PostgreSQL.

Repositorio: https://github.com/AnthonnyM31/Proyecto_NexusV-V2
