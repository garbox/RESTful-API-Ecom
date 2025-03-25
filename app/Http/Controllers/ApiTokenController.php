<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ApiToken;
use Dedoc\Scramble\Attributes\HeaderParameter;

class ApiTokenController extends Controller
{
    /**
     * Show all API tokens.
     * 
     * @response ApiToken[]
     */ 
    #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('user-api-key', description: 'Admin API Token', type: 'string')]
    public function index(){
        $tokens = ApiToken::all();

        if ($tokens->isEmpty()) {
            return response()->json(['message' => 'There are no API tokens.'], 404);
        }

        return response()->json($tokens, 200);
    }
    /**
     * Create an API token.
     * 
     * @response ApiToken[]
     */ 
    #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('user-api-key', description: 'Admin API Token', type: 'string')]
    public function store(Request $request){
        $validatedData = $request->validate([
            'app_name' => 'required|string|max:255',
        ]);

        $validatedData['api_token'] = Str::random(34);

        $apiToken = ApiToken::create($validatedData);

        return response()->json($apiToken, 201);
    }
    /**
     * Show an API token.
     * 
     * @response ApiToken[]
     */ 
    #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('user-api-key', description: 'Admin API Token', type: 'string')]
    public function show(string $apiToken){
        $token = ApiToken::where('api_token', $apiToken)->first();

        if (!$token) {
            return response()->json(['message' => 'API token not found.'], 404);
        }

        return response()->json($token, 200);
    }

    /**
     * Update an API token name
     * 
     * @response ApiToken[]
     */ 
    #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('user-api-key', description: 'Admin API Token', type: 'string')]
    public function update(Request $request){
        $token = ApiToken::find($request->id);

        if (!$token) {
            return response()->json(['message' => 'API token not found.'], 404);
        }

        $validatedData = $request->validate([
            'app_name' => 'required|string|max:255',
        ]);

        $token->update(array_filter($validatedData));

        return response()->json($token, 200);
    }

    /**
     * Delete an API token.
     * 
     * 
     */ 
    #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('user-api-key', description: 'Admin API Token', type: 'string')]
    public function destroy(Request $request){
        $token = ApiToken::find($request->id);
    
        if (!$token) {
            return response()->json(['message' => 'Application token cannot be found.'], 404);
        }
    
        $token->delete();
    
        return response()->json(['message' => 'Application token deleted successfully.'], 200);
    }
}