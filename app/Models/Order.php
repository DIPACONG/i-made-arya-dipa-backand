<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'email',
        'method',
        'total',
        'status',
        'items',
    ];

    protected $casts = [
        'total' => 'float',
        'items' => 'array',
    ];
}
