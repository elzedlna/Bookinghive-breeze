<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if ($request->user()->role !== $role) {
            return redirect($this->getDashboardRoute($request->user()->role));
        }
        return $next($request);
    }

    private function getDashboardRoute($role)
    {
        switch ($role) {
            case 'admin':
                return route('admin.dashboard');
            case 'hotel':
                return route('hotel.dashboard');
            default:
                return route('user.dashboard');
        }
    }
}
