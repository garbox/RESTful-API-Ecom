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
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
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
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
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
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
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
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
    public function update(Request $request, $id){
        $token = ApiToken::find($id);

        if (!$token) {
            return response()->json(['message' => 'API token not found.'], 404);
        }

        $validatedData = $request->validate([
            'app_name' => 'nullable|string|max:255',
        ]);

        $token->update(array_filter($validatedData));

        return response()->json($token, 200);
    }

    /**
     * Delete an API token.
     * 
     * @response ApiToken[]
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
    public function destroy($id){
        $token = ApiToken::find($id);

        if (!$token) {
            return response()->json(['message' => 'API token cannot be found.'], 404);
        }

        if ($token->delete()) {
            return response()->json(['message' => 'API token deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Failed to delete API token.'], 500);
        }
    }
}