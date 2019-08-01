<?php

namespace Turing\Attribute\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class AttributeValueResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        return $data;
    }
}
