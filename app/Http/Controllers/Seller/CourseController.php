<?php

namespace App\Http\Controllers\Seller; 

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View; // Importar View para los métodos create y edit
use Illuminate\Http\RedirectResponse; // Importar RedirectResponse para store, update, destroy

class CourseController extends Controller
{
    /**
     * Muestra la lista de cursos creados por el vendedor autenticado. (CORREGIDO: usa paginate)
     */
    public function index(): View
    {
        // Obtener SOLO los cursos asociados al usuario logueado, usando paginate para la vista.
        $courses = Auth::user()->courses()->latest()->paginate(10); 

        // Retorna la vista específica para la gestión del vendedor (seller-index)
        return view('courses.seller-index', compact('courses')); 
    }

    /**
     * Muestra el formulario para crear un nuevo curso. (NUEVO MÉTODO)
     */
    public function create(): View
    {
        // Retorna la vista que contiene el formulario de creación.
        return view('courses.create'); 
    }
    
    /**
     * Almacena un curso recién creado en la base de datos. (NUEVO MÉTODO)
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validación de los datos
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'header' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'scheduled_date' => ['required', 'date', 'after:tomorrow'], 
            'price' => ['required', 'numeric', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        // 2. Creación del curso, asegurando que el user_id sea el del vendedor autenticado
        Auth::user()->courses()->create([
            'title' => $validatedData['title'],
            'header' => $validatedData['header'],
            'description' => $validatedData['description'],
            'scheduled_date' => $validatedData['scheduled_date'],
            'price' => $validatedData['price'],
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('seller.courses.index')->with('success', '¡Curso agendado y guardado correctamente!');
    }

    /**
     * Muestra un curso específico del vendedor. (No típicamente usado en la gestión, pero requerido por Route::resource)
     */
    public function show(Course $course)
    {
        abort(404); // Mantenemos el abort 404 para evitar acceso directo
    }
    
    /**
     * Muestra el formulario para editar un curso existente. (REQUERIDO POR Route::resource)
     */
    public function edit(Course $course): View
    {
        // Asegurar que el usuario es el propietario del curso
        if ($course->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('courses.edit', compact('course'));
    }

    /**
     * Actualiza un curso en la base de datos. (REQUERIDO POR Route::resource)
     */
    public function update(Request $request, Course $course): RedirectResponse
    {
        // Asegurar que el usuario es el propietario del curso
        if ($course->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Lógica de actualización (similar a store)
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'header' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'scheduled_date' => ['required', 'date', 'after:tomorrow'],
            'price' => ['required', 'numeric', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);
        
        $course->update([
            'title' => $validatedData['title'],
            'header' => $validatedData['header'],
            'description' => $validatedData['description'],
            'scheduled_date' => $validatedData['scheduled_date'],
            'price' => $validatedData['price'],
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('seller.courses.index')->with('success', '¡Curso actualizado correctamente!');
    }

    /**
     * Elimina un curso de la base de datos. (REQUERIDO POR Route::resource)
     */
    public function destroy(Course $course): RedirectResponse
    {
        // Asegurar que el usuario es el propietario del curso
        if ($course->user_id !== Auth::id()) {
            abort(403);
        }
        
        $course->delete();

        return redirect()->route('seller.courses.index')->with('success', 'Curso eliminado correctamente.');
    }
}