<?php

namespace App\Http\Middleware;

use Closure;
use SSO\SSO;
use Session;
use Illuminate\Support\Facades\Auth;

class SSOForceLogin
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
            $AuthEntry = false;
            // Check overall authentication
            if(SSO::check()){
                session(['SSOEntry' => 'true']);
                $SSOEntry = true;
            }else{
                session(['SSOEntry' => 'false']);
                $SSOEntry = false;
            }
        }else{
            session(['AuthEntry' => 'true']);
            $AuthEntry = true;
            $SSOEntry = false;
        }
        
        // Check authentication for all doors
        if($SSOEntry == false && $AuthEntry == false){
            Session::flash('status2', 'Your session has ended. Please login again!');
            return redirect('login');
        }
        return $next($request);
    }
}
