<?php

namespace Turing\Cart\Http\Controllers;

use Turing\Backend\Http\Controllers\BaseController;

/**
 * Class CartController
 * @package Turing\Cart\HttpControllers
 */
class CartController extends BaseController
{
    public function generateId()
    {
        $response = $this->repository->generateId();
        return $this->respondeWithResource($response);
    }

    public function showCartItems(string $id)
    {
        return $this->respondeWithResource($this->repository->getItemsInCart($id));
    }

    public function create()
    {
        $model = $this->repository->add(collect($this->request->toArray()));
        $collection = $this->repository->getItemsInCart($model->cart_id);
        return $this->respondeWithResource($collection);
    }

    public function update(int $id)
    {
        $model = $this->repository->update($id, collect($this->request->toArray()));
        $collection = $this->repository->getItemsInCart($model->cart_id);
        return $this->respondeWithResource($collection);
    }

    public function saveForLater(int $id)
    {
        $this->repository->saveForLater($id, collect($this->request->toArray()));
        return response("", 200);
    }

    public function delete(int $id)
    {
        $this->repository->delete($id);
        return response("", 200);
    }

    public function deleteCart(string $id)
    {
        return $this->respondeWithResource($this->repository->delectCart($id));
    }

    public function moveToCart(int $id)
    {
        $this->repository->moveToCart($id, collect($this->request->toArray()));
        return response("", 200);
    }

    public function getSaved(string $id)
    {
        $model = $this->repository->getSaved($id, collect($this->request->toArray()));
        return $this->respondeWithResource($model);
    }

    public function cartTotal(string $id)
    {
        return $this->respondeWithResource($this->repository->getCartTotal($id));
    }
}
