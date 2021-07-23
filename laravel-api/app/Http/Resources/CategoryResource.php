<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
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
            'parent_id' => $this->parent_id,
            'children' => count($this->children) > 0 ? self::collection($this->children) : null,
            'children_count' => count($this->children),
            'products_count' => $this->products ? $this->products->count() : null,
            'products_count_total' => $this->loopCategories($this, $this->products->count()),
        ];
    }

    public function loopCategories($category, $proCounter)
    {
        if (count($category->children) > 0) {
            foreach ($category->children as $child) {
                if ($child->products->count()) {
                    $proCounter += $child->products->count();
                }
                if (count($child->children) > 0) {
                    $proCounter += $this->loopCategories($child, $proCounter);
                }
            }
        }
        return $proCounter;
    }
}
