<?php

namespace Turing\Attribute\Http\Controllers;

use mysql_xdevapi\Collection;
use Turing\Attribute\Http\Resources\AttributeValueResource;
use Turing\Backend\Http\Controllers\BaseController;

/**
 * Class AttributeController
 * @package Turing\Attribute\Http\Controllers
 */
class AttributeController extends BaseController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return $this->respondWithResourceCollection($this
            ->repository->collection(collect($this->request->toArray()))
            ->getCollection());
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function show(int $id)
    {
        return $this->respondeWithResource($this->repository->item($id, collect($this->request->toArray())));
    }

    /**
     * @param int $id
     * @return AttributeValueResource
     */
    public function getAttributeValues(int $id)
    {
        return new AttributeValueResource($this->repository->getAttributeValues($id, collect($this->request->toArray())));
    }

    /**
     * @param int $id
     * @return AttributeValueResource
     */
    public function getAttributesInProduct(int $id)
    {
        return new AttributeValueResource($this->repository->getAttributesInProduct($id, collect($this->request->toArray())));
    }
}
