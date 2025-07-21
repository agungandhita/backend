<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'kelas',
        'foto',
        'role',
        'phone',
        'bio',
        'is_active',
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime'
    ];

    /**
     * Relasi ke Score
     */
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    /**
     * Relasi ke Favorites
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Relasi ke Tools melalui Favorites
     */
    public function favoriteTools()
    {
        return $this->belongsToMany(Tool::class, 'favorites');
    }

    /**
     * Check if user has favorited a tool
     */
    public function hasFavorited($toolId)
    {
        return $this->favorites()->where('tool_id', $toolId)->exists();
    }

    /**
     * Update last login timestamp
     */
    public function updateLastLogin()
    {
        $this->update(['last_login_at' => now()]);
    }

    /**
     * Get user progress (dummy data for now)
     */
    public function getProgressAttribute()
    {
        $totalQuizzes = 15; // 5 per level
        $completedQuizzes = $this->scores()->count();

        return [
            'total_kuis' => $totalQuizzes,
            'selesai' => $completedQuizzes,
            'persentase' => $totalQuizzes > 0 ? round(($completedQuizzes / $totalQuizzes) * 100, 2) : 0
        ];
    }

    /**
     * Get user progress percentage only
     */
    public function getProgressPercentageAttribute()
    {
        $totalQuizzes = 15; // 5 per level
        $completedQuizzes = $this->scores()->count();

        return $totalQuizzes > 0 ? round(($completedQuizzes / $totalQuizzes) * 100, 2) : 0;
    }
}
