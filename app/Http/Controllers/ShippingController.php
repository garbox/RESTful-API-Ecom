<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipping;

class ShippingController extends Controller
{
    public function index(){
        $shipping = Shipping::all();
        if($shipping->isEmpty()){
            return response()->json([
                'message' => 'There are no shipping information avaliable.',
            ], 404);
        }
        return response()->json($shipping->toJson(), 201);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|integer|',
            'state' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'user_id' => 'required|exists:users,id',
            'order_id' => 'required|exists:orders,id'
        ]);

        $shipping = Shipping::create($validatedData);
    
        return response()->json($shipping->toJson(), 201);
    }

    public function show(int $shippingId){
        $shipping = Shipping::find($shippingId);

        if(!$shipping){
            return response()->json([
                'message' => 'There are no shipping info with ID provided.',
                'shipping' => $shipping,
            ], 404);
        }

        return response()->json($shipping->toJson(), 200);
    }

    public function update(Request $request, int $shippingId){
        $shipping = Shipping::find($shippingId);

        if (!$shipping) {
            return response()->json(['error' => 'Shipping info not found'], 404);
        }

        $validatedData = collect($request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip' => 'nullable|integer|',
            'state' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]));

        $updatedData = $validatedData->filter(function ($value) {
            return !is_null($value);
        });

        $shipping->update($updatedData->toArray());

        return response()->json($shipping->toJson(), 200);
    }

    public function destroy(int $shippingId){
        $shipping = Shipping::find($shippingId);

        if (!$shipping) {
            return response()->json(['message' => 'Shipping info cannot be found.'], 404);
        }
        
        if ($shipping->delete()) {
            return response()->json(['message' => 'Shipping info deleted successfully.'], 200);
        } 
        else {
            return response()->json(['message' => 'Failed to delete shipping info.'], 500);
        }
    }

    //-------Not used but reponse needed --->
    public function edit(){
        return response()->json([
            'message' => "Please use PUT PATCH api/shipping/*shippingId* to update shipping info"
        ],404);
    }

    public function create(){
        return response()->json([
            'message' => "Please use POST api/shipping with proper payload to create shipping information"
        ],404);
    }


}
