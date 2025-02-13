<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiToken;

class CheckApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY'); 
        $apiKey = 'GdfJnteyWvgyPFrRN5nLzJKnpWUnBk84i7'; 
        if (!$apiKey) {
            return response()->json(['message' => 'API key is missing'], 400);
        }

        $token = ApiToken::where('api_token', $apiKey)->first();

        if (!$token) {
            return response()->json(['message' => 'Unauthorized or Invalid API Token'], 401);
        }

        return $next($request);
    }
}


