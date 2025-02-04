<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public static function store(Request $request){
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the product type
        $productType = ProductType::create($request->all());

        return response()->json([
            'message' => 'Product type created successfully.',
            'product_type' => $productType
        ], 201);
    }

    public static function show(int $id){
        $productType = ProductType::find($id);

        if (!$productType) {
            return response()->json(['message' => 'Product type not found.'], 404);
        }

        return response()->json($productType);        
    }

    public static function updateProductType(int $id, array $data){
        // Find the product type by ID
        $productType = ProductType::find($id);

        if ($productType) {
            // Update the product type with the provided data
            $productType->update($data);

            return response()->json([
                'message' => 'Product type updated successfully.',
                'product_type' => $productType
            ]);
        }

        return response()->json(['message' => 'Product type not found.'], 404);
    }

    public static function getProducts(int $productTypeId){
        $products = ProductType::with('products.productType')->find($productTypeId);

        return $products;
    }

    //--------realationships---------
    public function products(): HasMany{
        return $this->hasMany(Product::class);
    }
}
