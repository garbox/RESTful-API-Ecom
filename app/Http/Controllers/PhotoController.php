<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class PhotoController extends Controller
{
    public function index(){
        $photos = Photo::all();
    
        if ($photos->isEmpty()) {
            return response()->json([
                'message' => 'There are no photos.',
                'photos' => null,
            ], 404);
        }
    
        return response()->json($photos->toJson(), 200);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'file_name' => 'required|array',
            'file_name.*' => 'file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $filePaths = [];
        if ($request->hasFile('file_name')) {
            foreach ($request->file('file_name') as $file) {
                $filePaths[] = $file->store('photos');  // Ensure files are stored in 'photos/'
            }
        }
    
        $photos = [];
        foreach ($filePaths as $filePath) {
            $photos[] = Photo::create([
                'product_id' => $validatedData['product_id'],
                'file_name' => $filePath,
            ]);
        }
    
        return response()->json($photos->toJson(), 201);
    }
    
    public function show(int $photoId){
        $photo = Photo::find($photoId);

        if(!$photo){
            return response()->json([
                'message' => 'Photo not found',
            ], 404);
        }

        return response()->json($photo->toJson(),200);
    }

    public function destroy(int $photoId){
        $photo = Photo::find($photoId);

        if (!$photo) {
            return response()->json(['message' => 'Photo cannot be found.'], 404);
        }
        
        if ($photo->delete()) {
            return response()->json(['message' => 'Photo deleted successfully.'], 200);
        } 
        else {
            return response()->json(['message' => 'Failed to delete photo.'], 500);
        }
    }

    //-------Not used but reponse needed --->
    public function edit(){
        return response()->json([
            'message' => "Please use PUT PATCH api/photo/{photoId} to update photo info"
        ],404);
    }

    public function create(){
        return response()->json([
            'message' => "Please use POST api/photo with proper payload to uploade photo"
        ],404);
    }
}
