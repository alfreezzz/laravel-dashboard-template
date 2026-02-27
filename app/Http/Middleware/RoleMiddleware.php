<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request and require a specific role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles  Comma-separated allowed roles (e.g. "admin,user")
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $roles)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $allowed = explode(',', $roles);
        if (! in_array(Auth::user()->role, $allowed)) {
            abort(403);
        }

        return $next($request);
    }
}
