<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function index(): Response
    {
        $author = Author::first();
        
        return Inertia::render('AboutMe', [
            'author' => $author,
        ]);
    }
}
