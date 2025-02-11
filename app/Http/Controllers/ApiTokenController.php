<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiToken;
use Illuminate\Support\Str;

class ApiTokenController extends Controller
{

    public function index(){
        $tokens = ApiToken::all();

        if($tokens->isEmpty()){
            return response()->json([
                'message' => 'There are no API tokens.',
            ], 404);
        }

        return response()->json($tokens, 201);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'app_name' => 'required|string|max:255',
        ]);
        
        $validatedData['api_token'] = Str::random(25);
    
        $apiToken = ApiToken::create($validatedData);
    
        return response()->json($apiToken, 201);
    }

    public function show(string $apiToken){
        $token = ApiToken::find($apiToken);

        if(!$token){
            return response()->json([
                'message' => 'API token not found.'
            ], 404);
        }

        return response()->json($token, 200);
    }

    public function update(Request $request, int $apiToken){
        $token = ApiToken::find($apiToken);

        if (!$token) {
            return response()->json(['message' => 'API token not found'], 404);
        }

        $validatedData = $request->validate([
            'app_name' => 'nullable|string|max:255',
        ]);

        $token->app_name = $validatedData['app_name'];
        $token->save(); 

        return response()->json($token, 200); // HTTP 200 OK
    }

    public function destroy(int $apiToken){
        $token = ApiToken::find($apiToken);

        if (!$token) {
            return response()->json(['message' => 'API token cannot be found.'], 404);
        }
        
        if ($token->delete()) {
            return response()->json(['message' => 'API token deleted successfully.'], 200);
        } 
        else {
            return response()->json(['message' => 'Failed to delete API token.'], 500);
        }
    }
}
