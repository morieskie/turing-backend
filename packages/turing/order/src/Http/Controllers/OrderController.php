<?php

namespace Turing\Order\Http\Controllers;

use Turing\Backend\Http\Controllers\BaseController;

/**
 * Class OrderController
 * @package Turing\Order\Http\Controllers
 */
class OrderController extends BaseController
{

    public function create()
    {
        $model = \JWTAuth::parseToken()->authenticate();
        $data = collect($this->request->toArray());
        $data->put('customer_id', $model->customer_id);
        $model = $this->repository->add($data);
        return $this->respondeWithResource([
            'orderId' => $model->order_id
        ]);
    }

    public function show(int $id)
    {
        return $this->respondeWithResource($this->repository->details($id, collect($this->request->toArray())));
    }

    public function getOrder(int $id)
    {
        return $this->respondeWithResource($this->repository->getOrder($id, collect($this->request->toArray())));
    }

    public function showShortDetail(int $id)
    {
        return $this->respondeWithResource($this->repository->summary($id, collect($this->request->toArray())));
    }

    public function customerOrders()
    {
        $model = \JWTAuth::parseToken()->authenticate();
        return $this->respondeWithResource($this->repository->getCustomerOrders($model->customer_id, collect($this->request->toArray())));
    }
}
