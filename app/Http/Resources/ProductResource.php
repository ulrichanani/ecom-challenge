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
        return [
            'product_id' => $this->product_id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'discounted_price' => $this->discounted_price,
            'image' => $this->image,
            'image2' => $this->image2,
            'thumbnail' => $this->thumbnail,
            'display' => $this->display,
            'attributes' => $this->attributes,
            'categories' => $this->categories,
        ];
        // return parent::toArray($request);
    }
}
