<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductType;

class ProductTypeController extends Controller
{
    public function index(){
        $productType = ProductType::all();

        if($productType->isEmpty()){
            return response()->json([
                'message' => 'There are no product types.',
                'product_type' => null,
            ], 200);
        }

        return response()->json($productType->toJson(),200);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $productType = ProductType::create($validatedData);
    
        return response()->json($productType->toJson(), 201);
    }

    public function show(int $prodTypeId){
        $prodType = ProductType::find($prodTypeId);

        if(!$prodType){
            return response()->json([
                'message' => 'There are no product types with id provided.',
                'product_type' => $prodType,
            ], 404);
        }

        return response()->json($prodType->toJson(),200);
    }

    public function update(Request $request, int $productTypeId){
        $productType = ProductType::find($productTypeId);
        if (!$productType) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $validatedData = collect($request->validate([
            'name' => 'nullable|string|max:255',
        ]));

        $updatedData = $validatedData->filter(function ($value) {
            return !is_null($value);
        });

        $productType->update($updatedData->toArray());

        return response()->json($productType->toJson(), 200);
    }

    public function destroy(int $productTypeId){
        $productType = ProductType::find($productTypeId);

        if (!$productType) {
            return response()->json(['message' => 'Product type cannot be found.'], 404);
        }
        
        if ($productType->delete()) {
            return response()->json(['message' => 'Product type deleted successfully.'], 200);
        } 
        else {
            return response()->json(['message' => 'Failed to delete product type.'], 500);
        }
    }

    public function products(int $prodTypeId){
        $prodType = ProductType::find($prodTypeId);

        if(!$prodType){
            return response()->json([
                'message' => 'Product type does not exsiste.',
                'product_type' => null,
                'products' => null,
            ], 404);
        }

        $products = ProductType::getProducts($prodTypeId);
        if($products->products->isEmpty()){
            return response()->json([
                'message' => 'No products where found for this product type.',
                'product_type' => null,
            ], 200);
        }

        return response()->json($products->toJson(),200);
    }

    //-------Not used but reponse needed --->
    public function edit(){
        return response()->json([
            'message' => "Please use PUT PATCH api/prodtype/*prodtypeId* to update admin info",
        ],404);
    }

    public function create(){
        return response()->json([
            'message' => "Please use POST api/prodtype with proper payload to create a cart item.",
        ],404);
    }
}
