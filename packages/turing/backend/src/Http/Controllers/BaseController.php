<?php

namespace Turing\Backend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Pagination\AbstractPaginator;
use Turing\Backend\Repository\RepositoryInterface;

/**
 * Class BaseController
 * @package Turing\Backend\Http\Controllers
 */
class BaseController extends Controller
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Resource
     */
    protected $resource;
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    public function __construct(Request $request, Resource $resource, RepositoryInterface $repository)
    {
        $this->request = $request;
        $this->resource = $resource;
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->respondWithResourceCollection($this->repository->collection(collect($this->request->toArray())));
    }

    public function respondWithResourceCollection($collection)
    {

        return $this->resource->collection($collection);
    }

    public function respondeWithResource($model)
    {
        return new $this->resource($model);
    }
}
