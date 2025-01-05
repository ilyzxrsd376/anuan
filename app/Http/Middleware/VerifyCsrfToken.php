<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;


class VerifyCsrfToken
{
    protected $except = [
        '/api/login', // tambahkan route yang dikecualikan dari CSRF
        '/quiz/answer',
        '/profile/update',
        '/chat/send',
        '/forum/post'
    ];    
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
}
