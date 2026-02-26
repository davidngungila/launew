<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdminUser
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            abort(403);
        }

        if ($user->email === 'admin@lauparadise.com') {
            return $next($request);
        }

        if (method_exists($user, 'hasAnyRole')) {
            $allowed = $user->hasAnyRole([
                'System Administrator',
                'Admin / General Manager',
                'Booking Manager',
                'Travel Consultant',
                'Tour Operator',
                'Finance Officer',
                'Accountant',
                'Marketing Officer',
                'Sales Officer',
                'Operations Manager',
                'Driver / Guide',
                'External Agent',
                'Branch Manager',
                'IT Support',
            ]);

            if (!$allowed) {
                abort(403);
            }
        }

        return $next($request);
    }
}
