<?php

namespace App\Http\Middleware;

use Closure;

class SessionStart
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
        return $next($request);
    }

    public function terminate($request, $response)
    {

        if ($request->session()->exists('user')) {
            // Session anomaly
            $request->session()->forget('user');
        }
        // Store the session data
        $request->session()->put('user', $request->input('id'));
    }
}
