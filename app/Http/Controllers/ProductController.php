<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Dedoc\Scramble\Attributes\HeaderParameter;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Show all products
     * 
     *
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
    public function index()
    {
        $products = Product::with('category', 'photos')->get();
    
        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'There are no products.',
                'products' => null,
            ], 404);
        }
    
        return ProductResource::collection($products);
    }

    /**
     * Create a product
     * 
     * @response Product
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
    public function store(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'short_description' => 'required|string',
            'long_description' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id',
            'featured' => 'required|boolean',
            'available' => 'nullable|boolean',
        ]);
        
        $product = Product::create($validatedData);
    
        return response()->json($product, 200);
    }

    /**
     * Show a product
     * 
     * 
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    public function show(int $productId){
        $product = Product::with('category','photos')->find($productId);

        if(!$product){
            return response()->json(['message' => 'Product not found'], 404);
        }

        return new ProductResource($product);
    }

    /**
     * Update a product
     * 
     * @response Product
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
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

    /**
     * Delete a product
     * 
     * 
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
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

    /**
     * Show all featured products
     * 
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    public function featured(){
        $products = Product::featured()->with('category', 'photos')->get();

        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'There are no products featured at the moment.',
            ], 404);
        }

        return ProductResource::collection($products);
    }

    /**
     * Show all products that are available
     * 
     *
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    public function available(){
        $products = Product::available()->with('category', 'photos')->get();

        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'There are no products featured at the moment.',
            ], 404);
        }

        return ProductResource::collection($products);
    }

    /**
     * Search for products
     * 
     * 
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    public function search(string $search){
        $result = Product::where('name','LIKE','%'.$search.'%')->with('category', 'photos')
        ->get();

        return ProductResource::collection($result);
    }
}
