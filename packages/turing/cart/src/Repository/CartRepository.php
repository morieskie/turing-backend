<?php


namespace Turing\Cart\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use League\Fractal\Resource\Item as ResourceItem;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Turing\Backend\Repository\RepositoryInterface;
use Turing\Cart\Model\Cart;

/**
 * Class CartRepository
 * @package Turing\Cart\Repository
 */
class CartRepository implements RepositoryInterface
{

    /**
     * @var Cart|Model|Builder|\Illuminate\Database\Query\Builder
     */
    private $model;

    public function __construct(Cart $model)
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
            ->select('item_id', 'name', 'attributes', 'product_id', 'price', 'quantity', 'image', 'subtotal')
            ->find($id);
    }

    /**
     * @param Collection|null $filters
     * @return Paginator
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

    public function generateId()
    {
        return [
            'cart_id' => Str::random(32)
        ];
    }

    /**
     * @param Collection $data
     * @return Model
     */
    public function add(Collection $data): Model
    {
        $data->put('added_on', date('Y-m-d H:i:s'));
        $data->put('quantity', $data->get('quantity', 1));
        $model = $this->model
            ->where('product_id', $data->get('product_id'))
            ->where('cart_id', $data->get('cart_id'));
        if ($model->count() > 0) {
            $model = $model->first();
            $model->update(['quantity' => $model->quantity + 1]);

        } else {
            $model = $this->model->create($data->only('cart_id', 'product_id', 'attributes', 'added_on', 'quantity')->toArray());
        }
        return $model->fresh();
    }

    /**
     * @param int $id
     * @param Collection $data
     * @return Model
     */
    public function update(int $id, Collection $data): Model
    {
        /** @var Model $model */
        $model = $this->model->findOrFail($id);
        $model->update($data->only('quantity')->toArray());

        return $model->fresh();
    }

    /**
     * @param int $id
     * @param Collection $data
     * @return Model
     */
    public function saveForLater(int $id, Collection $data = null): Model
    {
        /** @var Model $model */
        $model = $this->model->findOrFail($id);
        $model->update(['buy_now' => false]);

        return $model->fresh();
    }

    /**
     * @param int $id
     * @param Collection $data
     * @return Model
     */
    public function moveToCart(int $id, Collection $data = null): Model
    {
        /** @var Model $model */
        $model = $this->model->findOrFail($id);
        $model->update([
            'buy_now' => true,
            'added_on' => date('Y-m-d H:i:s')
        ]);

        return $model->fresh();
    }

    /**
     * @param int $id
     * @param Collection $data
     * @return Model
     */
    public function getSaved(string $id, Collection $data = null): Collection
    {
        return $this->model
            ->select('item_id', 'product.name', 'attributes',
                \DB::raw('COALESCE(NULLIF(product.discounted_price, 0), product.price) AS price'))
            ->join('product', 'product.product_id', '=', 'shopping_cart.product_id')
            ->where('cart_id', $id)
            ->where('buy_now', false)
            ->get();
    }

    /**
     * @param int $id
     * @param Collection $data
     * @return Collection
     */
    public function getItemsInCart(string $id, Collection $data = null): Collection
    {
        return $this->model
            ->select('item_id', 'product.name', 'attributes', 'shopping_cart.product_id', 'quantity', 'image',
                \DB::raw('COALESCE(NULLIF(product.discounted_price, 0), product.price) AS price'),
                \DB::raw('COALESCE(NULLIF(product.discounted_price, 0), product.price) * quantity AS subtotal'))
            ->join('product', 'product.product_id', '=', 'shopping_cart.product_id')
            ->where('cart_id', $id)
            ->where('buy_now', true)
            ->get();
    }

    /**
     * @param int $id
     * @param Collection $data
     * @return Collection
     */
    public function getCartTotal(string $id, Collection $data = null)
    {
        return $this->model
            ->select(\DB::raw('SUM(COALESCE(NULLIF(product.discounted_price, 0), product.price) * quantity) AS total_amount'))
            ->join('product', 'product.product_id', '=', 'shopping_cart.product_id')
            ->where('cart_id', $id)
            ->where('buy_now', true)
            ->first();
    }

    /**
     * @param int $id
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function delete(int $id)
    {
        $model = $this->model->findOrFail($id);
        return $model->delete();
    }

    public function deleteCart(string $cartId)
    {
        $model = $this->model
            ->where('cart_id', $cartId)
            ->where('buy_now', true);

        if ($model->count() === 0) {
            throw new NotFoundHttpException();
        }

        $model->delete();

        return [];
    }
}
