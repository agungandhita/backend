<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'icon'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->nama);
            }
        });
        
        static::updating(function ($category) {
            if ($category->isDirty('nama') && empty($category->slug)) {
                $category->slug = Str::slug($category->nama);
            }
        });
    }

    public function tools()
    {
        return $this->hasMany(Tool::class);
    }
}