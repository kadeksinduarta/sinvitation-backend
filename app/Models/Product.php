<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'price',
        'description',
        'image',
        'preview_link',
        'has_photo',
        'status',
    ];

    protected $casts = [
        'has_photo' => 'boolean',
    ];
}
