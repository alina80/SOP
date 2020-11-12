<?php

namespace App\Http\Middleware;

use Closure;

class IsEmployeeMiddleware
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
        if (!auth()->user()->is_employee) {
            abort(403);
        }

        return $next($request);
    }
}
