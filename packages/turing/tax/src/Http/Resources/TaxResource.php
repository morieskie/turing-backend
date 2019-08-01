<?php

namespace Turing\Tax\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TaxResource extends Resource
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
