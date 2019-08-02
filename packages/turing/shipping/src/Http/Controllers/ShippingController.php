<?php

namespace Turing\Shipping\Http\Controlllers;

use Turing\Backend\Http\Controllers\BaseController;

/**
 * Class ShippingController
 * @package Turing\Shipping\Http\Controlllers
 */
class ShippingController extends BaseController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return $this->respondWithResourceCollection($this->repository
            ->collection(collect($this->request->toArray()))
            ->getCollection());
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function show(int $id)
    {
        return $this->respondWithResourceCollection($this->repository->getRegionsByShippingRegionId($id, collect($this->request->toArray())));
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getShipping(int $id)
    {
        return $this->respondeWithResource($this->repository->getShipping($id, collect($this->request->toArray())));
    }
}
