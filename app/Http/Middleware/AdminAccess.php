<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Admin;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->api_token = $request->header('ADMIN-API-KEY'); 
        $admin = Admin::verifyToken($request->api_token);

        if(!$admin){
            return response()->json(['message' => 'Admin API key is invalid'], 400);
        }

        $request->merge(['authed_admin' => $admin]);

        return $next($request);
    }
}
