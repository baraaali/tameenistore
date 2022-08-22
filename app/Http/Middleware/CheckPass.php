<?php

namespace App\Http\Middleware;

use Closure;

class CheckPass
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
        if ($request->password_api !=env('API_PASSWORD','PN36UyLK_OFs3')) {

            return response()->json(['message'=>'Unauth']);

        }
        return $next($request);
    }
}
