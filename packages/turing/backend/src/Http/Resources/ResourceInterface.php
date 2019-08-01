<?php


namespace Turing\Backend\Http\Resources;


interface ResourceInterface
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request);


}
