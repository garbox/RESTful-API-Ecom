<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'permissions', "api_token"
    ];

    protected $hidden = [
        'permissions', 'password', 'created_at', 'updated_at'
    ];
    
    public static function verifyCredentials(array $credentials){
        $admin = Admin::where('email', $credentials['email'])->first();
    
        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            return $admin;
        }
    
        return null; 
    }
    
}
