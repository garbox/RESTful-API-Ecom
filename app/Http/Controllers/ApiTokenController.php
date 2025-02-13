<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ApiToken;

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

        $validatedData['api_token'] = Str::random(34);
    
        $apiToken = ApiToken::create($validatedData);
    
        return response()->json($apiToken, 201); // Explicitly converting to an array
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

    public function update(Request $request){
        $token = ApiToken::where('api_token', $request->header('X-API-KEY'))->first();

        $validatedData = collect($request->validate([
            'app_name' => 'nullable|string|max:255',
        ]));

        $updatedData = array_filter($validatedData, function ($value) {
            return !is_null($value);
        });
    
        $token->update($updatedData);

        return response()->json($token, 200);
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
