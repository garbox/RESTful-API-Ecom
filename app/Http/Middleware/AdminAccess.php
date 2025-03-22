<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Admin;
use App\Models\ApiToken;
use Illuminate\Support\Facades\Log;

class AdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiToken = $request->header('user-api-key');

        if (!$apiToken) {
            return response()->json(['message' => 'Admin API token is required'], 400);
        }

        $admin = ApiToken::verifyToken(Admin::class, $apiToken);
        
        if (!$admin) {
            return response()->json(['message' => 'Admin API token is invalid'], 400);
        }
    
        $request->merge([
            'authed_user' => $admin, 
            'typeOfUser' => 'admin'
        ]);
    
        return $next($request);
    }
    
}
