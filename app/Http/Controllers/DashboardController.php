<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard según el rol del usuario.
     */
    public function index()
    {
        $user = auth()->user();

        // 1. Redirección del Administrador
        if ($user->isAdmin()) {
            return redirect()->route('admin.users.index');
        }

        // 2. Redirección del Vendedor
        if ($user->isSeller()) {
            return redirect()->route('seller.courses.index');
        }

        // 3. Lógica del Comprador (Dashboard)
        $enrollments = Enrollment::with('course.user')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('dashboard', compact('enrollments'));
    }
}
