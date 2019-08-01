<?php

namespace Turing\Payment\Http\Controllers;

use Illuminate\Http\Request;
use Turing\Backend\Http\Controllers\BaseController;
use Turing\Payment\Http\Resources\StripeResource;
use Turing\Payment\Repository\StripeRepository;

/**
 * Class StripeController
 * @package Turing\Payment\Http\Controllers
 */
class StripeController extends BaseController
{

    public function __construct(Request $request, StripeResource $resource, StripeRepository $repository)
    {
        $this->request = $request;
        $this->resource = $resource;
        $this->repository = $repository;
    }

    public function process(){

        $data = collect([
            'amount' => $this->request->get('amount'),
            'currency' => $this->request->get('currency', 'usd'),
            'source' => $this->request->get('stripeToken'),
            'description' => $this->request->get('description'),
            'meta' => ['order_id' => 'order_id']
        ]);

        return $this->respondeWithResource(collect($this->repository->processPayment($data)));
    }

    public function getToken(){
        return $this->respondeWithResource($this->repository->createCardToken(collect($this->request->toArray())));
    }

    public function handle(){
        return;
    }

}
