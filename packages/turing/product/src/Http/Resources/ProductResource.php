<?php

namespace Turing\Product\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Turing\Backend\Http\Resources\ResourceInterface;

class ProductResource extends Resource implements ResourceInterface
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
