<?php

namespace Turing\Customer\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use League\Fractal\Resource\Item as ResourceItem;
use Turing\Backend\Exceptions\FailedHttValidationException;
use Turing\Backend\Repository\RepositoryInterface;
use Turing\Customer\Model\Customer;

/**
 * Class CustomerRepository
 * @package Turing\Customer\Repository
 */
class CustomerRepository implements RepositoryInterface
{

    /**
     * @var Customer
     */
    private $model;

    public function __construct(Customer $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $id
     * @param Collection|null $filters
     * @return ResourceItem
     */
    public function item(int $id, Collection $filters = null): Model
    {
        return $this->model->find($id);
    }

    /**
     * @param Collection|null $filters
     * @return AbstractPaginator
     */
    public function collection(Collection $filters = null): Paginator
    {
        // TODO: Implement collection() method.
    }

    /**
     * @param Collection $data
     * @return Model
     */
    public function add(Collection $data): Model
    {
        $model = $this->model->create([
            'name' => $data->get('name'),
            'email' => $data->get('email'),
            'password' => Hash::make($data->get('password')),
        ]);

        return $model->fresh();
    }

    /**
     * @param int $id
     * @param Collection $data
     * @return Model
     */
    public function update(int $id, Collection $data): Model
    {
        $model = $this->model->find($id);
        $model->update($data->only('name', 'email', 'password', 'day_phone', 'eve_phone', 'mob_phone')->toArray());

        return $model;
    }

    /**
     * @param int $id
     * @param Collection $data
     * @return Model
     */
    public function updateAddress(int $id, Collection $data): Model
    {
        $model = $this->model->find($id);
        $model->update($data->only('address_1', 'address_2', 'city', 'region', 'postal_code', 'country', 'shipping_region_id')->toArray());

        return $model->fresh();
    }

    /**
     * @param int $id
     * @param Collection $data
     * @return Model
     */
    public function updateCreditCard(int $id, Collection $data): Model
    {
        $model = $this->model->find($id);
        $data->put('credit_card', str_pad(substr($data->get('credit_card'), -4), 16, 'X', STR_PAD_LEFT));
        $model->update($data->only('credit_card')->toArray());

        return $model->fresh();
    }

    /**
     * @param int $id
     * @return Model
     */
    public function delete(int $id): Model
    {
        // TODO: Implement delete() method.
    }

    public function getCustomerOrders(int $id): Collection
    {
        return $this->model
            ->select('orders.order_id', 'orders.total_amount', 'orders.created_on',
                'orders.shipped_on', 'orders.status', 'customer.name')
            ->where('orders.customer_id', $id)
            ->join('orders', 'orders.customer_id', '=', 'customer.customer_id')
            ->orderBy('orders.created_on', 'desc')
            ->get();
    }

    /**
     * @param string $string
     * @return Model|null
     * @throws FailedHttValidationException
     */
    public function getFacebookUser(string $string)
    {
        $user = Socialite::driver('facebook')->stateless()->userFromToken($string);
        if (empty($user->getEmail())) {
            $validator = Validator::make([], []);
            $validator->errors()->add('access_token', 'Invalid permission grant for access token, please include email.');
            throw new FailedHttValidationException($validator);
        }

        $model = $this->model->where('email', $user->getEmail())->first();

        if (!$model) {
            $data = collect([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => $string,
            ]);
            $model = $this->add($data);
            $model = $model->fresh();
        }

        return $model;
    }
}
