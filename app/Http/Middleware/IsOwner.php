<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isOwner()) {
            return response()->json([
                'status'  => false,
                'message' => 'Akses ditolak. Hanya owner yang dapat mengakses fitur ini.',
            ], 403);
        }

        return $next($request);
    }
}
