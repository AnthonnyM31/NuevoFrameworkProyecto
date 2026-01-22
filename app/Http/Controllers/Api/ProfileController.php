<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function me(Request $request)
    {
        $user = $request->user();
        $enrollments = $user->enrollments()->with('course')->get();

        return response()->json([
            'user' => $user,
            'enrollments' => $enrollments
        ]);
    }
}
