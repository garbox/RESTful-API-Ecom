<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        $products = Product::with('productType')->get();
    
        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'There are no products.',
                'products' => null,
            ], 404);
        }
    
        return response()->json([
            'products' => $products
        ], 200);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'short_description' => 'required|string',
            'long_description' => 'nullable|string',
            'product_type_id' => 'required|exists:product_types,id',
            'featured' => 'required|boolean',
            'available' => 'nullable|boolean',
        ]);
    
        $product = Product::create($validatedData);
    
        return response()->json($product, 201);
    }

    public function show(int $productId){
        $product = Product::with('productType','photos')->find($productId);

        if(!$product){
            return response()->json($product, 404);
        }

        return response()->json([
            'product' => $product,
        ], 200);
    }

    public function update(Request $request, int $productId){
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $validatedData = collect($request->validate([
            'name' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'product_type_id' => 'nullable|exists:product_types,id',
            'featured' => 'nullable|boolean',
            'available' => 'nullable|boolean',
        ]));

        $updatedData = $validatedData->filter(function ($value) {
            return !is_null($value);
        });

        $product->update($updatedData->toArray());

        return response()->json($product, 200); // HTTP 200 OK
    }

    public function destroy(int $productId){
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['message' => 'Product cannot be found.'], 404);
        }
        
        if ($product->delete()) {
            return response()->json(['message' => 'Product deleted successfully.'], 200);
        } 
        else {
            return response()->json(['message' => 'Failed to delete product.'], 500);
        }
    }

    public function featured(){
        $products = Product::featured()->get();

        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'There are no products featured at the moment.',
                'products' => null,
            ], 404);
        }

        return response()->json([
            'products' => $products
        ], 200);

    }

    public function available(){
        $products = Product::available()->get();

        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'There are no products avaliable for the customer at the moment.',
                'products' => null,
            ], 404);
        }

        return response()->json([
            'products' => $products
        ], 200);

    }

    //-------Not used but reponse needed --->
    public function edit(){
        return response()->json([
            'message' => "Please use PUT PATCH api/product/*productId* to update admin info"
        ],404);
    }

    public function create(){
        return response()->json([
            'message' => "Please use POST api/product with proper payload to create admin user"
        ],404);
    }
}
