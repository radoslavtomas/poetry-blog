<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'cover',
        'publishing_year',
        'publishing_house',
        'description',
        'pdf_path',
    ];

    protected function casts(): array
    {
        return [
            'title' => AsArrayObject::class,
            'publishing_house' => AsArrayObject::class,
            'description' => AsArrayObject::class,
        ];
    }

    public function poems(): HasMany
    {
        return $this->hasMany(Poem::class)->orderBy('position_in_book');
    }
}
