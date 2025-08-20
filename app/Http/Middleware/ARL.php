<?php

namespace Deschool\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class ARL
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
           
        if(Auth::user()->isAdmin()){
           return $next($request); 
        } 
        }                
           

        
         
    }
}
