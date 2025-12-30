<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Poem extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'body',
        'book_id',
        'source_id',
        'position_in_book',
    ];

    protected $casts = [
        'title' => 'array',
        'body' => 'array',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('book_id')
            ->orWhereNotNull('source_id');
    }

    public function scopeUnpublished(Builder $query): Builder
    {
        return $query->whereNull('book_id')
            ->whereNull('source_id');
    }

    public function scopeByBook(Builder $query): Builder
    {
        return $query->whereNotNull('book_id')
            ->orderBy('position_in_book');
    }

    public function scopeBySource(Builder $query): Builder
    {
        return $query->whereNotNull('source_id')
            ->whereNull('book_id');
    }
}
