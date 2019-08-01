<?php

namespace Turing\Attribute\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AttributeCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        die(print_r($this->sql));
        return [
            "attribute_name" => $this->name,
            "attribute_value_id" => $this->pivot->name,
            "attribute_value" => $this->pivot->name
        ];
    }
}
