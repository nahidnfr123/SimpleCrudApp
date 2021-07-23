<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
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
        /*$proCounter = $this->products->count() ?: 0;
        if (count($this->children)) {
            foreach ($this->children as $child) {
                foreach ($child->children as $child1) {
                    if ($child1->products->count()) {
                        $proCounter += $child1->products->count();
                    }
                }
                if ($child->products->count()) {
                    $proCounter += $child->products->count();
                }
            }
        }*/

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'user_id' => $this->user_id,
            'parent_id' => $this->parent_id,
            'children' => count($this->children) > 0 ? self::collection($this->children) : null,
            'children_count' => count($this->children),
            'products_count' => $this->products ? $this->products->count() : null,
            //'products_count_total' => $proCounter,
        ];
    }
}
