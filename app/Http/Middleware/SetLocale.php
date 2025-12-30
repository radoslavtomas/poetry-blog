<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if locale is in session
        $locale = $request->session()->get('locale');
        
        // If not in session, use default (sk)
        if (!$locale || !in_array($locale, ['sk', 'en'])) {
            $locale = 'sk';
        }
        
        app()->setLocale($locale);
        
        return $next($request);
    }
}
