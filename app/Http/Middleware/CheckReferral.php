<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckReferral
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if( $request->hasCookie('referral')) {
            return $next($request);
        }
        else {
            if( $request->query('ref') ) {
                return redirect($request->fullUrl())->withCookie(cookie()->forever('referral', $request->query('ref')));
            }
        }
        
        return $next($request);
    }
}
