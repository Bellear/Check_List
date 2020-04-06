<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class userblocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // проверяем принадлежность пользователя
        if ( Auth::check() && Auth::user()->isBlocked() != 1 )
        {
            return $next($request);
        }
        return redirect('/');
    }
}
