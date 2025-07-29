<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'gambar',
        'deskripsi',
        'fungsi',
        'url_video',
        'file_pdf',
        'kategori',
        'is_active',
        'tags',
        'category_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_active' => 'boolean',
        'tags' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }





    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }



    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nama', 'LIKE', "%{$search}%")
              ->orWhere('deskripsi', 'LIKE', "%{$search}%")
              ->orWhere('fungsi', 'LIKE', "%{$search}%");
        });
    }
}
