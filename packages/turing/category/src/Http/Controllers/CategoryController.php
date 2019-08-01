<?php

namespace Turing\Category\Http\Controllers;

use Turing\Backend\Http\Controllers\BaseController;

/**
 * Class CategoryController
 * @package Turing\Category\Http\Controllers
 */
class CategoryController extends BaseController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return $this->respondWithResourceCollection($this->repository->collection(collect($this->request->toArray())));
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
     * @return mixed
     */
    public function getCategoriesInProduct(int $id)
    {
        return $this->respondWithResourceCollection($this->repository->getCategoriesInProduct($id, collect($this->request->toArray())));
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getCategoriesInDepartment(int $id)
    {
        return $this->respondWithResourceCollection($this->repository->getCategoriesInDepartment($id, collect($this->request->toArray())));
    }
}
