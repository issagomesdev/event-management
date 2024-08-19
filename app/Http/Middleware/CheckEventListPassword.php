<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEventListPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = 'Listinhagjota';
        $password = 'gjotalistinha05';

        if($request->get('password') && $request->get('user')){
            if ($request->get('password') !== $password || $request->get('user') !== $user) {
                session()->flash('error', 'Dados incorretos. Por favor, tente novamente.');
                return response()->view('public.events.password-protect');
            }
        } else {
            return response()->view('public.events.password-protect');
        }

        return $next($request);
    }
}
