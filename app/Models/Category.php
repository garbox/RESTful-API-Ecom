<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public static function getProducts(int $categoryId){
        $products = Category::with('products.category')->find($categoryId);

        return $products;
    }

    //--------realationships---------
    public function products(): HasMany{
        return $this->hasMany(Product::class);
    }
}
