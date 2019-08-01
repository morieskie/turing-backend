<?php

namespace Turing\Department\Http\Controlllers;

use Turing\Backend\Http\Controllers\BaseController;

/**
 * Class DepartmentController
 * @package Turing\Department\Http\Controlllers
 */
class DepartmentController extends BaseController
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
        return $this->respondeWithResource($this->repository->item($id, collect($this->request->toArray())));
    }
}
