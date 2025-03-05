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
        $apiToken = $request->header('USER_API_KEY');

        if (!$apiToken) {
            return response()->json(['message' => 'User API token is required'], 400);
        }

        $user = ApiToken::verifyToken(User::class, $apiToken);

        if (!$user) {
            return response()->json(['message' => 'User API key is invalid'], 400);
        }
    
        $request->merge([
            'authed_user' => $user, 
            'typeOfUser' => 'user'
        ]);
    
        return $next($request);
    }
    
}
