<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiToken;

class CheckApiKey
{
    public function handle(Request $request, Closure $next)
    {

        $apiKey = $request->header('GLOBAL_API_KEY');

        if (!$apiKey) {
            return response()->json(['message' => 'Application API key is missing'], 404);
        }

        if (!ApiToken::where('api_token', $apiKey)->first()) {
            return response()->json(['message' => 'Unauthorized or invalid application API key'], 401);
        }
        
        return $next($request);
    }
}


