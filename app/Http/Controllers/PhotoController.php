<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use Dedoc\Scramble\Attributes\HeaderParameter;

class PhotoController extends Controller
{
    /**
     * Get all photos
     * 
     * @response Photo[]
     * 
     */ 
   #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
   #[HeaderParameter('user-api-key', description: 'Admin API Token', type: 'string')]
    public function index(){
        $photos = Photo::all();
    
        if ($photos->isEmpty()) {
            return response()->json([
                'message' => 'There are no photos.',
                'photos' => null,
            ], 404);
        }
    
        return response()->json($photos, 200);
    }

    /**
     * Store a new photo/photos
     * 
     * @response Photo[]
     * 
     */ 
   #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
   #[HeaderParameter('user-api-key', description: 'Admin API Token', type: 'string')]
    public function store(Request $request){
        $validatedData = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'file_name' => 'required|array',
            'file_name.*' => 'file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $filePaths = [];
        if ($request->hasFile('file_name')) {
            $filePaths = array_map(fn($file) => $file->store('photos'), $request->file('file_name'));
        }
    
        $photos = array_map(fn($filePath) => Photo::create([
            'product_id' => $validatedData['product_id'],
            'file_name' => $filePath,
        ]), $filePaths);
    
        return response()->json($photos, 201);
    }
    
    /**
     * Show a photo.
     * 
     * @response Photo
     * 
     */ 
   #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
    public function show(int $photoId){
        $photo = Photo::find($photoId);

        if(!$photo){
            return response()->json([
                'message' => 'Photo not found',
            ], 404);
        }

        return response()->json($photo,200);
    }

    /**
     * Destroy a photo.
     * 
     * @response Photo
     * 
     */ 
    #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('user-api-key', description: 'Admin API Token', type: 'string')]
    public function destroy(int $photoId){
        $photo = Photo::find($photoId);
    
        if (!$photo) {
            return response()->json(['message' => 'Photo cannot be found.'], 404);
        }
    
        $photo->delete();
    
        return response()->json(['message' => 'Photo deleted successfully.'], 200);
    }
}
