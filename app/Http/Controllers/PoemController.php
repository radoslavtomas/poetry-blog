<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Poem;
use App\Models\Source;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class PoemController extends Controller
{
    public function index(): Response
    {
        // Get poems grouped by books (ordered by position_in_book)
        $poemsByBooks = Book::with(['poems' => function ($query) {
            $query->orderBy('position_in_book');
        }])->has('poems')->get();
        
        // Get poems by sources (sorted alphabetically by first word of body)
        $poemsBySources = Source::with(['poems' => function ($query) {
            $query->orderByRaw('JSON_EXTRACT(body, "$." || ? || "") ASC', [app()->getLocale()]);
        }])->has('poems')->get();
        
        // Get unpublished poems (sorted alphabetically by first word of body)
        $unpublishedPoems = Poem::unpublished()
            ->orderByRaw('JSON_EXTRACT(body, "$." || ? || "") ASC', [app()->getLocale()])
            ->get();
        
        return Inertia::render('AllPoems', [
            'poemsByBooks' => $poemsByBooks,
            'poemsBySources' => $poemsBySources,
            'unpublishedPoems' => $unpublishedPoems,
        ]);
    }
    
    public function show(Poem $poem): Response
    {
        $poem->load(['book', 'source']);
        
        $prevPoem = null;
        $nextPoem = null;
        
        // If poem is part of a book, get prev/next poems
        if ($poem->book_id) {
            $prevPoem = Poem::where('book_id', $poem->book_id)
                ->where('position_in_book', '<', $poem->position_in_book)
                ->orderBy('position_in_book', 'desc')
                ->first();
                
            $nextPoem = Poem::where('book_id', $poem->book_id)
                ->where('position_in_book', '>', $poem->position_in_book)
                ->orderBy('position_in_book', 'asc')
                ->first();
        }
        
        return Inertia::render('Poem', [
            'poem' => $poem,
            'prevPoem' => $prevPoem,
            'nextPoem' => $nextPoem,
        ]);
    }
}
