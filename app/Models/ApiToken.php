<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Admin;
use App\Models\User;

class ApiToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_name', 'api_token', 'admin_token'
    ];

    
    public static function verifyToken(string $model, ?string $token)
    {
        return $model::where('api_token', $token)->first();
    }
}
