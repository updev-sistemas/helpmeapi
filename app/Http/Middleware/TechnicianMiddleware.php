<?php

namespace App\Http\Middleware;

use App\Types\UserType;
use Closure;

class TechnicianMiddleware
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
        if($request->user()->paper_id != UserType::TECHNICIAN) {
            throw new \Exception("Você não tem permissão de acesso a esse ambiente!");
        }
        return $next($request);
    }
}
