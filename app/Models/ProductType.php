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

    public static function getProducts(int $productTypeId){
        $products = ProductType::with('products.productType')->find($productTypeId);

        return $products;
    }

    //--------realationships---------
    public function products(): HasMany{
        return $this->hasMany(Product::class);
    }
}
