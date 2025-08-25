<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsGuard
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Check if user is logged in and has usertype "guard"
        $typeName = strtolower(optional($user->userType)->type_name);
        
        if (!$user || $typeName !== 'guard') {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
