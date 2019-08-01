<?php


namespace Turing\Product\Http\Controllers;

use Illuminate\Contracts\Pagination\Paginator;
use Turing\Backend\Http\Controllers\BaseController;

/**
 * Class ProductController
 * @package Turing\Product\Http\Controllers
 */
class ProductController extends BaseController
{
    public function index()
    {
        /** @var \Illuminate\Pagination\LengthAwarePaginator|Paginator $pagination */
        $pagination = $this->repository->collection(collect($this->request->toArray()));
        $collection = $pagination->getCollection();
        \Log::info(print_r($pagination->total(),1));
        $count = $pagination->total();
        $rows = $collection;

        return $this->respondeWithResource(collect(compact('count', 'rows')));
    }

    public function search()
    {
        $results = $this->repository->search(collect($this->request->toArray()));
        return $this->respondeWithResource($results);
    }

    public function show(int $id)
    {
        return $this->respondeWithResource($this->repository->item($id));
    }

    public function details(int $id)
    {
        return $this->respondeWithResource($this->repository->details($id));
    }

    public function productsInCategory(int $id)
    {
        $pagination = $this->repository->productsInCategory($id, collect($this->request->toArray()));
        $collection = $pagination->getCollection();
        $response = collect([
            'count' => $pagination->total(),
            'rows' => $collection
        ]);

        return $this->respondeWithResource($response);
    }

    public function productsInDepartment(int $id)
    {
        $pagination = $this->repository->productsInDepartment($id, collect($this->request->toArray()));
        $collection = $pagination->getCollection();
        $response = collect([
            'count' => $pagination->total(),
            'rows' => $collection
        ]);

        return $this->respondeWithResource($response);
    }

    public function locations(int $id){
        $collection = $this->repository->locations($id);
        return $this->respondeWithResource($collection);
    }

    public function reviews(int $id){
        $collection = $this->repository->reviews($id);
        return $this->respondeWithResource($collection);
    }

    public function review(int $id){
        $model = \JWTAuth::parseToken()->authenticate();
        $data = collect($this->request->toArray());
        $data->put('customer_id' , $model->customer_id);
        $data->put('product_id', $id);
        $collection = $this->repository->review($id,$data);
        return response("");
    }
}
