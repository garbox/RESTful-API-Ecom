<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'short_description' => $this->short_description,
            'long_description' => $this->long_description,
            'product_type_id' => $this->product_type_id,
            'featured' => $this->featured,
            'available' => $this->available,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'photos' => PhotoResource::collection($this->whenLoaded('photos')),
        ];
    }
}
