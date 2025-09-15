<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenantId = $request->header('X-Tenant-ID');
        
        if (!$tenantId) {
            return response()->json([
                'message' => 'Tenant ID is required. Please provide X-Tenant-ID header.'
            ], 400);
        }
        
        // Verify tenant exists and is active
        $tenant = \App\Models\Tenant::where('id', $tenantId)
            ->where('status', 'active')
            ->first();
            
        if (!$tenant) {
            return response()->json([
                'message' => 'Invalid or inactive tenant.'
            ], 403);
        }
        
        // Add tenant to request for controller access
        $request->merge(['current_tenant' => $tenant]);
        
        return $next($request);
    }
}