<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->api_token = $request->header('USER-API-KEY');
        $user = User::verifyToken($request->api_token);
        
        if(!$user){
            return response()->json(['message' => 'User API key is invalid'], 400);
        }

        $request->merge(['authed_user' => $user]);

        return $next($request);
    }
}
