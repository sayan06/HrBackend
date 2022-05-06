<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorizeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $permission)
    {
        if (!Auth::guard('sanctum')->user()->hasPermissionTo($permission)) {
            return $this->respondUnauthorized();
        }

        return $next($request);
    }

    private function respondUnauthorized()
    {
        return response()->json(
            [
                'error' => [
                    'message' => 'Unauthorized!',
                    'status_code' => 403,
                ],
            ],
            403,
        );
    }
}
