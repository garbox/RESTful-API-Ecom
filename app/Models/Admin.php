<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'permissions'
    ];

    public static function store(Validator $validator){
        $admin = Admin::create([
            'name' => $validator->name,
            'email' => $validator->email,
            'password' => Hash::make($validator->password),
            'role' => $validator->role,
            'permissions' => $validator->permissions,
        ]);

        return $admin;
    }

    public static function updateAdmin(int $id, Request $request){
        $admin->update([
            'name' => $request->name ?? $admin->name,
            'email' => $request->email ?? $admin->email,
            'password' => $request->password ? bcrypt($request->password) : $admin->password,
            'role' => $request->role ?? $admin->role,
            'permissions' => $request->permissions ?? $admin->permissions,
        ]);

        return $admin;
    }

}
