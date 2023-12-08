<?php

namespace App\Http\Middleware;

use App\Contract\Roles;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $availableRoles = Roles::getAllValues();
                $roles = Auth::user()->getRoleNames();

                foreach ($roles as $role) {
                    if (in_array($role, $availableRoles)) {
                        $redirectTo = Roles::from($role)->getRedirectRoute();
                        
                        return redirect($redirectTo);
                    }
                }

                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
