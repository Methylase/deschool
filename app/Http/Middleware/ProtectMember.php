<?php

namespace Corox\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class ProtectMember
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
            if(Auth::user()->isMember()){
                return $next($request);
            }
            return redirect('/Dregister/dashboard');
    }
}
