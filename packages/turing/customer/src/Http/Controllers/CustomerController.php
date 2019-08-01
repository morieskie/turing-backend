<?php

namespace Turing\Customer\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Turing\Backend\Exceptions\FailedHttValidationException;
use Turing\Backend\Http\Controllers\BaseController;

/**
 * Class CustomerController
 * @package Turing\Customer\Http\Controllers
 */
class CustomerController extends BaseController
{
    public function update()
    {
        $data = collect($this->request->toArray());
        try {
            if (!$user = \JWTAuth::parseToken()->authenticate()) {
                $validator = Validator::make([],[]);
                $validator->errors()->add('API_KEY', 'Invalid token');
                throw new FailedHttValidationException($validator);
            }
        } catch (\JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $model = $this->repository->update($user->customer_id, $data);

        return $this->respondeWithResource($model);
    }

    public function show(int $id)
    {
        $data = collect($this->request->toArray());
        $model = $this->repository->item($id, $data);

        return $this->respondeWithResource($model);
    }

    public function create()
    {
        $data = collect($this->request->toArray());
        $model = $this->repository->add($data);

        $token = \JWTAuth::fromUser($model);

        $response = collect([
            'customer' => $model,
            'accessToken' => 'Bearer ' . $token
        ]);

        return $this->respondeWithResource($response);
    }

    public function updateAddress()
    {
        $data = collect($this->request->toArray());
        try {
            $model = \JWTAuth::parseToken()->authenticate();
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            $validator = Validator::make([],[]);
            $validator->errors()->add('API-KEY', $e->getMessage());
            throw new FailedHttValidationException($validator);
        } catch (\JWTException $e) {
            $validator = Validator::make([],[]);
            $validator->errors()->add('API-KEY', $e->getMessage());
            throw new FailedHttValidationException($validator);
        }
        $data->put('customer_id', $model->customer_id);
        $model = $this->repository->updateAddress($model->customer_id, $data);

        return $this->respondeWithResource($model);
    }

    public function updateCreditCard()
    {
        $data = collect($this->request->toArray());
        $model = \JWTAuth::parseToken()->authenticate();
        $data->put('customer_id', $model->customer_id);
        $model = $this->repository->updateCreditCard($model->customer_id, $data);

        return $this->respondeWithResource($model);
    }

    public function authenticate()
    {
        $credentials = $this->request->only('email', 'password');

        try {
            if (!$token = \JWTAuth::attempt($credentials)) {
                $validator = Validator::make([],[]);
                $validator->errors()->add('password', 'Email or Password is invalid.');
                throw new FailedHttValidationException($validator);
            }
        } catch (\JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = \JWTAuth::user();

        return $this->respondeWithResource([
            'customer' => ['schema' => $user],
            'accessToken' => 'Bearer '.$token
        ]);
    }

    public function authenticateFacebook()
    {
        $model = $this->repository->getFacebookUser($this->request->get('access_token'));
        $token = \JWTAuth::fromUser($model);

        return $this->respondeWithResource([
            'customer' => ['schema' => $model],
            'accessToken' => 'Bearer '.$token
        ]);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = \JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (\Exception $e){
            $validator = Validator::make([],[]);
            $validator->errors()->add('API-KEY', $e->getMessage());
            throw new FailedHttValidationException($validator);
        }

        return $this->respondeWithResource($user);
    }
}
