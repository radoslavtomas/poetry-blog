<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Inertia\Inertia;
use Inertia\Response;

class BookController extends Controller
{
    public function index(): Response
    {
        $books = Book::withCount('poems')->get();
        
        return Inertia::render('Books', [
            'books' => $books,
        ]);
    }
    
    public function show(Book $book): Response
    {
        $book->load(['poems' => function ($query) {
            $query->orderBy('position_in_book');
        }]);
        
        return Inertia::render('Book', [
            'book' => $book,
        ]);
    }
}
