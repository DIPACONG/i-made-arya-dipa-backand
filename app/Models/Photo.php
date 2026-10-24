<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    use HasFactory;

    // Primary key non-default (sesuai pedoman modul BAB III)
    protected $primaryKey = 'photo_id';

    // Fields yang boleh diisi massal
    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'photographer',
        'tags',
        'w',
        'h',
        'price',
        'img',
        'downloads',
        'description',
    ];

    protected $casts = [
        'tags'      => 'array',
        'w'         => 'integer',
        'h'         => 'integer',
        'price'     => 'float',
        'downloads' => 'integer',
    ];

    /**
     * Relasi ke tabel categories (Many-to-One: Foto dimiliki oleh satu Kategori)
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Accessor untuk mendapatkan Full URL gambar
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->img) {
            return null;
        }

        if (str_starts_with($this->img, 'http://') || str_starts_with($this->img, 'https://')) {
            return $this->img;
        }

        return url('storage/' . ltrim($this->img, '/'));
    }
}
