<?php

namespace App\Models;

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

    protected $casts = [
        'title' => 'array',
        'publishing_house' => 'array',
        'description' => 'array',
    ];

    public function poems(): HasMany
    {
        return $this->hasMany(Poem::class)->orderBy('position_in_book');
    }
}
