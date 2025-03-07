<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Dedoc\Scramble\Attributes\HeaderParameter;

class CategoryController extends Controller
{
    /**
     * Show all categories
     * 
     * @response Category[]
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
    public function index(){
        $categories = Category::all();

        if ($categories->isEmpty()) {
            return response()->json([
                'message' => 'There are no product types.',
                'product_type' => null,
            ], 200);
        }

        return response()->json($categories, 200);
    }

    /**
     * Create a category
     * 
     * @response Category
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($validatedData);

        return response()->json($category, 201);
    }

    /**
     * Show a category
     * 
     * @response Category
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
    public function show(int $categoryId){
        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json([
                'message' => 'There are no product types with the provided ID.',
                'product_type' => null,
            ], 404);
        }

        return response()->json($category, 200);
    }

    /**
     * Update a category
     * 
     * @response Category
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
    public function update(Request $request, int $categoryId){
        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
        ]);

        $category->update(array_filter($validatedData));

        return response()->json($category, 200);
    }

    /**
     * Delete a category
     * 
     *
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
    public function destroy(int $categoryId){
        $category = Category::find($categoryId);
    
        if (!$category) {
            return response()->json(['message' => 'Product type cannot be found.'], 404);
        }
    
        $category->delete();
    
        return response()->json(['message' => 'Category deleted successfully.'], 200);
    }

    /**
     * Find all products in a category
     * 
     * @response Product[]
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    public function products(int $categoryId){
        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json([
                'message' => 'Category does not exist.',
            ], 404);
        }

        $products = $category->products;

        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'No products were found for this category.',
            ], 200);
        }

        return response()->json($products, 200);
    }
}