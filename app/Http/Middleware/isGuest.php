<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah ada history login, dia gabole masuk ke login lagi bakal di redirect lagi ke todo
        if (Auth::check()) {
            return redirect()->route('todo.index')->with('notAllowed', 'Silahkan login terlebih dahulu!');
        }
        
        // Kalau gaada history login, baru boleh next ke login 
        return $next($request);
    }
}
