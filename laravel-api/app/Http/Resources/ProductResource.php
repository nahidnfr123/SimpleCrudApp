<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'total_stock' => $this->total_stock,
            'price' => $this->price,
            'image' => $this->image,
            'description' => html_entity_decode($this->description),
            'categories' => count($this->productCategory) > 0 ? CategoryResource::collection($this->productCategory) : null,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
