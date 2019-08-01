<?php


namespace Turing\Order\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;
use League\Fractal\Resource\Item as ResourceItem;
use Turing\Backend\Repository\RepositoryInterface;
use Turing\Cart\Repository\CartRepository;
use Turing\Customer\Repository\CustomerRepository;
use Turing\Order\Model\Order;

/**
 * Class OrderRepository
 * @package Turing\Order\Repository
 */
class OrderRepository implements RepositoryInterface
{

    /**
     * @var Order|Model|\Illuminate\Database\Query\Builder|Builder
     */
    private $model;

    public function __construct(Order $model)
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
        return $this->model
            ->select('order_id', 'product_id', 'attributes', 'product_name', 'quantity', 'unit_cost', \DB::raw("(quantity * unit_cost) AS subtotal"))
            ->find($id);
    }

    /**
     * @param int $id
     * @param Collection|null $filters
     * @return Collection
     */
    public function details(int $id, Collection $filters = null): Collection
    {
        return $this->model->findOrFail($id)
            ->orderDetails()
            ->select('order_id', 'product_id', 'attributes', 'product_name', 'quantity',
                'unit_cost', \DB::raw("(quantity * unit_cost) AS subtotal"))
            ->get($id);
    }

    /**
     * @param int $id
     * @param Collection|null $filters
     * @return Collection
     */
    public function summary(int $id, Collection $filters = null): Model
    {
        return $this->model
            ->select('orders.order_id', 'orders.total_amount', 'orders.created_on',
                'orders.shipped_on', 'orders.status', 'customer.name')
            ->join('customer', 'orders.customer_id', '=', 'customer.customer_id')
            ->findOrFail($id);
    }

    /**
     * @param Collection|null $filters
     * @return AbstractPaginator
     */
    public function collection(Collection $filters = null): Paginator
    {
        $columns = <<<SQL
        product.product_id, product.name,
        IF(LENGTH(product.description) <= ?, product.description, CONCAT(LEFT(product.description, ?),'...')) AS description,
        product.price, product.discounted_price, product.thumbnail
SQL;

        $pagination = $this->model->selectRaw($columns, [
            $filters->get('description_length', 200),
            $filters->get('description_length', 200),
        ])->paginate($filters->get('limit', 20));

        return $pagination;
    }

    /**
     * @param Collection $data
     * @return Model
     */
    public function add(Collection $data): Model
    {
        $cartId = $data->get('cart_id');

        /** @var CartRepository $cartRepository */
        $cartRepository = app(CartRepository::class);

        /** @var Order|Model $orderModel */
        $orderModel = $this->model->create([
            'total_amount' => $cartRepository->getCartTotal($cartId)->total_amount,
            'customer_id' => $data->get('customer_id'),
            'shipping_id' => $data->get('shipping_id'),
            'tax_id' => $data->get('tax_id'),
            'created_on' => date('Y-m-d H:i:s'),
        ]);

        /** @var Collection $cartItems */
        $cartItems = app(CartRepository::class)->getItemsInCart($data->get('cart_id'))
            ->map(function ($item) use ($orderModel) {
                return [
                    'order_id' => $orderModel->order_id,
                    'product_id' => $item->product_id,
                    'attributes' => $item->attributes,
                    'product_name' => $item->name,
                    'quantity' => $item->quantity,
                    'unit_cost' => $item->price
                ];
            });

        $orderModel->orderDetails()->createMany($cartItems->toArray());

        $cartRepository->deleteCart($cartId);

        return $orderModel;
    }

    public function getCustomerOrders(int $id, Collection $filters = null)
    {
        $customerRepository = app(CustomerRepository::class);
        return $customerRepository->getCustomerOrders($id);
    }

    /**
     * @param int $id
     * @param Collection $data
     * @return Model
     */
    public function update(int $id, Collection $data): Model
    {
        // TODO: Implement update() method.
    }

    /**
     * @param int $id
     * @return Model
     */
    public function delete(int $id): Model
    {
        // TODO: Implement delete() method.
    }
}
