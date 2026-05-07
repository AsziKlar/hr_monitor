<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles){
        if (! auth()->check()) {
            //change this when the routes is ararnged
             return redirect('/login');
        }
           

        if (! in_array(auth()->user()->role->name, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}
