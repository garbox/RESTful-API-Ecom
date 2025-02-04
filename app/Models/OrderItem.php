<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id', 'quantity'
    ];

    public static function store(int $orderId, Request $request){
        
    }

    //--------relationship--------
    public function order(){
        return $this->belongsTo(Order::class);
    }
}
