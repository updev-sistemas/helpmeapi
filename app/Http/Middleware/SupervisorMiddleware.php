<?php

namespace App\Http\Middleware;

use App\Types\UserType;
use Closure;

class SupervisorMiddleware
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
        if($request->user()->paper_id == UserType::SUPERVISOR_A || $request->user()->paper_id == UserType::SUPERVISOR_B) {
            return $next($request);
        }
        throw new \Exception("Você não tem permissão de acesso a esse ambiente!");
    }
}
