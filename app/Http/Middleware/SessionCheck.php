<?php

namespace App\Http\Middleware;

use Closure;

class SessionCheck
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
        if ($request->session()->exists('user')) {
            if($request->session()->get('user') == $request->input('uid') || $request->session()->get('user') == 'temporary'){
                return $next($request);
            }
        }
        // user value cannot be found in session
        return redirect('/');

    }
}
