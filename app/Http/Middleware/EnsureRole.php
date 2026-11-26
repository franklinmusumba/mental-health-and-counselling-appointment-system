<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please log in to continue.');
        }

        if (!in_array(Auth::user()->Role, $roles, true)) {
            abort(403, 'Access Denied: You do not have permission to view this page.');
        }

        return $next($request);
    }
}