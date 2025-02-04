<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use App\Models\ProductType;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'price', 'short_description', 'long_description', 'product_type_id', 'available', 'featured'
    ];

    public static function available(){
        return Product::with('productType')
        ->where('available', 1);
    }

    public static function featured(){
        return Product::with('productType')
        ->where('featured', 1);
    }

    //------relationships---------
    public function productType(): BelongsTo{
        return $this->belongsTo(ProductType::class);
    }

    public function cart(): HasMany{
        return $this->hasMany(Cart::class);
    }

    public function photos(): HasMany{
        return $this->hasMany(Photo::class);
    }
}
