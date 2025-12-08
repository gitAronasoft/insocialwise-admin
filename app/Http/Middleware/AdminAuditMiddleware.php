<?php

namespace App\Http\Middleware;

use App\Services\AdminAuditService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuditMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (Auth::guard('admin')->check()) {
            AdminAuditService::updateSessionActivity();
        }

        return $response;
    }
}
