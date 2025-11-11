<?php

namespace App\Models;

// Importaciones necesarias
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELACIONES Y HELPERS ---

    /**
     * Get the courses owned by the user (Seller).
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Get the enrollments made by the user (Buyer).
     * NUEVA RELACIÓN
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Helper para verificar si el usuario es un Vendedor.
     */
    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    /**
     * Helper para verificar si el usuario es un Comprador.
     */
    public function isBuyer(): bool
    {
        return $this->role === 'buyer';
    }
}