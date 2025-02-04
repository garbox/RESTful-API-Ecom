<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    // CRUD
    public static function create(Request $request){

    }

    public static function edit(int $id){
        
    }

    public static function get(int $id){
        return response()->json(Status::first($id));
    }

    public static function update(int $id, json $cart){

    }

    public static function delete(int $Status){
        // Find the post by ID and delete it
        $Status = Status::find($Status); // Assuming the ID of the post to delete is 1

        if ($Status) {
            $Status->delete();
            return response()->json(['message' => "Status item successfully deleted."]);
        } else {
            return response()->json(['message' => "Status item not found."]);
        }
    }

    //get all Status items
    public static function all(){
        return response()->json(Status::all());
    }

    // get Status by user ID
    public function userCart(int $userId){
        return response()->json(Status::where('user_id', $userId)->get());
    }
}
