<?php

namespace App\Http\Middleware;

use Closure;
use SSO\SSO;
use Session;
use Illuminate\Support\Facades\Auth;

class SSOCheck
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
        if(Auth::guest()){
            session(['AuthEntry' => 'false']);
            // Check overall authentication
            /* if(SSO::check()){
                Session::flash('SSOEntry', 'true');
            }else{
                Session::flash('SSOEntry', 'false');
            } */
        }else{
            session(['AuthEntry' => 'true']);
        }
        return $next($request);
    }
}
