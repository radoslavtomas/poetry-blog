<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'bio',
        'image_path',
    ];

    protected function casts(): array
    {
        return [
            'bio' => 'array',
        ];
    }
}
