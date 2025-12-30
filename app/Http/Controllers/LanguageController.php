<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    public function switch(Request $request, string $locale): RedirectResponse
    {
        if (in_array($locale, ['sk', 'en'])) {
            $request->session()->put('locale', $locale);
        }
        
        return redirect()->back();
    }
}
