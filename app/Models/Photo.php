<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'file_name'
    ];  

    //------relationships---------
    public function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }
}
