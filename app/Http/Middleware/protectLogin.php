<?php

namespace Deschool\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Deschool\Models\Deschool_model;
class protectLogin
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
        if(Auth::check()){

                    return $next($request);
          
        }else {
            return redirect()->route('login');
    }
}
}