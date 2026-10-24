<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    // jika primary key bukan 'id', tentukan di sini (sesuai modul BAB III)
    protected $primaryKey = 'category_id';

    // fields yang boleh diisi massal
    protected $fillable = ['category'];

    /**
     * Relasi ke tabel photos (One-to-Many: 1 Category memiliki banyak Photos)
     */
    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class, 'category_id');
    }

    /**
     * Accessor agar bisa diakses $category->name atau $category->category
     */
    public function getNameAttribute(): string
    {
        return $this->attributes['category'] ?? '';
    }
}
