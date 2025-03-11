<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApiToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_name', 'api_token'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public static function verifyToken(string $model, ?string $token){   
        return $model::where('api_token', $token)->first();
    }
}
