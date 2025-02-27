<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index(){
        $category = Category::all();

        if($category->isEmpty()){
            return response()->json([
                'message' => 'There are no product types.',
                'product_type' => null,
            ], 200);
        }

        return response()->json($category,200);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $category = Category::create($validatedData);
    
        return response()->json($category, 201);
    }

    public function show(int $categoryId){
        $category = Category::find($categoryId);

        if(!$category){
            return response()->json([
                'message' => 'There are no product types with id provided.',
                'product_type' => $category,
            ], 404);
        }

        return response()->json($category,200);
    }

    public function update(Request $request, int $categoryId){
        $category = Category::find($categoryId);
        if (!$category) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $validatedData = collect($request->validate([
            'name' => 'nullable|string|max:255',
        ]));

        $updatedData = $validatedData->filter(function ($value) {
            return !is_null($value);
        });

        $category->update($updatedData->toArray());

        return response()->json($category, 200);
    }

    public function destroy(int $categoryId){
        Log::alert($categoryId);
        $category = Category::find($categoryId);
        Log::alert($category);
        if (!$category) {
            return response()->json(['message' => 'Product type cannot be found.'], 404);
        }
        
        if ($category->delete()) {
            return response()->json(['message' => 'Product type deleted successfully.'], 200);
        } 
        else {
            return response()->json(['message' => 'Failed to delete product type.'], 500);
        }
    }

    public function products(int $categoryId){
        $category = Category::find($categoryId);

        if(!$category){
            return response()->json([
                'message' => 'Category does not exsiste.',
            ], 404);
        }

        $category = Category::getProducts($categoryId);
        if($category->products->isEmpty()){
            return response()->json([
                'message' => 'No products where found for this category.',
            ], 200);
        }

        return response()->json($category,200);
    }
}
