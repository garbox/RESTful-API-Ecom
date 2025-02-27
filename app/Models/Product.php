<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Photo;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'price', 'short_description', 'long_description', 'product_type_id', 'available', 'featured'
    ];

    public static function available(){
        return Product::with('category')
        ->where('available', 1);
    }

    public static function featured(){
        return Product::with('category')
        ->where('featured', 1)
        ->where('available', 1);
    }

    //------relationships---------
    public function category(): BelongsTo{
        return $this->belongsTo(Category::class);
    }

    public function cart(): HasMany{
        return $this->hasMany(Cart::class);
    }

    public function photos(): HasMany{
        return $this->hasMany(Photo::class);
    }

    public function orderItems(): HasMany{
        return $this->hasMany(OrderItem::class);
    }
}
