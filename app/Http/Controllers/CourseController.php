<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Muestra una lista de cursos publicados para los compradores, con búsqueda.
     */
    public function index(Request $request)
    {
        // Consulta solo cursos que han sido marcados como publicados
        $query = Course::with('user')
            ->where('is_published', true)
            ->latest('scheduled_date'); 

        // Implementar la búsqueda por título y encabezado
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('header', 'like', "%{$search}%");
            });
        }

        $courses = $query->paginate(12);

        return view('courses.public-index', compact('courses'));
    }

    /**
     * Muestra la vista de detalle de un curso.
     */
    public function show(Course $course)
    {
        // Redirección si el curso existe pero no está publicado
        if (!$course->is_published) {
            abort(404);
        }

        return view('courses.show', compact('course'));
    }
}