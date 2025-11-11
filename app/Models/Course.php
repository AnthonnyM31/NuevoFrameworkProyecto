<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // NUEVA Importación
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'header',
        'description',
        'scheduled_date',
        'price',
        'is_published',
    ];
    protected $casts = [
        'scheduled_date' => 'datetime', //si no agregamos esta linea protected al guardar la fecha tentativa en un curso se daña
    ];

    /**
     * Get the user (seller) that owns the course.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    // --- NUEVAS RELACIONES Y HELPERS ---

    /**
     * Get the users enrolled in this course.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Helper para verificar si un usuario ya está inscrito.
     */
    public function isEnrolled($userId): bool
    {
        return $this->enrollments()->where('user_id', $userId)->exists();
    }
}