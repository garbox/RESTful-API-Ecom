<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\ApiToken;

class UserAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiToken = $request->header('USER-API-KEY');
        
        if (!$apiToken) {
            return response()->json(['message' => 'API token is required'], 400);
        }
    
        $admin = ApiToken::verifyToken(User::class, $apiToken);  // Assuming verifyToken is checking the correct table
    
        if (!$admin) {
            return response()->json(['message' => 'Admin API key is invalid'], 400);
        }
    
        $request->merge(['authed_user' => $admin]);
    
        return $next($request);
    }
}
