<?php

namespace App\Http\Controllers;

use App\Models\Poem;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $poem = Poem::with(['book', 'source'])->inRandomOrder()->first();
        
        return Inertia::render('Home', [
            'poem' => $poem,
        ]);
    }
}
