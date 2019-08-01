<?php


namespace Turing\Product\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Turing\Backend\Repository\RepositoryInterface;
use Turing\Product\Model\Product;

/**
 * Class ProductRepository
 * @package Turing\Product\Repository
 */
class ProductRepository implements RepositoryInterface
{

    /**
     * @var Product
     */
    private $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $id
     * @param Collection|null $filters
     * @return Model
     */
    public function item(int $id, Collection $filters = null): Model
    {
        return $this->model->find($id);
    }

    /**
     * @param int $id
     * @param Collection|null $filters
     * @return Model
     */
    public function details(int $id, Collection $filters = null): Model
    {
        return $this->model
            ->select('product_id', 'name', 'description', 'price', 'discounted_price', 'image', \DB::raw("image_2 as image2"))
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
        ]);

        if ($filters->has('size') && !empty($filters->get('size'))) {
            $pagination->leftJoin('product_attribute', 'product.product_id', 'product_attribute.product_id');
            $pagination = $pagination->whereIn('product_attribute.attribute_value_id', explode(',', $filters->get('size')));
        }

        if ($filters->has('min') || $filters->has('max')) {
            $pagination = $pagination->whereBetween(\DB::raw('COALESCE(NULLIF(product.discounted_price, 0), product.price)'), [$filters->get('min'), $filters->get('max')]);
        }

        return $pagination->paginate($filters->get('limit', 15));
    }

    public function search(Collection $filters = null): Collection
    {
        $count = \DB::select('call catalog_count_search_result(?, ?)', [
                $filters->get('query_string'),
                $filters->get('all_words', 'on') === 'on' ? true : false,
            ])[0]->{'count(*)'} - 1;

        $rows = \DB::select('call catalog_search(?, ?, ?, ?, ?)', [
            $filters->get('query_string'),
            $filters->get('all_words', 'on'),
            $filters->get('description_length', 200),
            $filters->get('limit', 15),
            $filters->get('page', 1),
        ]);
        return collect(compact('count', 'rows'));
    }

    public function productsInCategory(int $id, Collection $filters = null): Paginator
    {
        $columns = <<<SQL
        distinct product.product_id, product.name,
        IF(LENGTH(product.description) <= ?, product.description, CONCAT(LEFT(product.description, ?),'...')) AS description,
        product.price, product.discounted_price, product.thumbnail
SQL;

        $pagination = $this->model
            ->selectRaw($columns, [
                $filters->get('description_length', 200),
                $filters->get('description_length', 200),
            ])
            ->whereHas('category', function (Builder $query) use ($id) {
                return $query->where('product_category.category_id', $id);
            });

        if ($filters->has('size') && !empty($filters->get('size'))) {
            $pagination->leftJoin('product_attribute', 'product.product_id', 'product_attribute.product_id');
            $pagination = $pagination->whereIn('product_attribute.attribute_value_id', explode(',', $filters->get('size')));
        }

        if ($filters->has('min') || $filters->has('max')) {
            $pagination = $pagination->whereBetween(\DB::raw('COALESCE(NULLIF(product.discounted_price, 0), product.price)'), [$filters->get('min'), $filters->get('max')]);
        }

        return $pagination->paginate($filters->get('limit', 15));
    }

    public function productsInDepartment(int $id, Collection $filters = null): Paginator
    {
        $columns = <<<SQL
        distinct product.product_id, product.name,
        IF(LENGTH(product.description) <= ?, product.description, CONCAT(LEFT(product.description, ?),'...')) AS description,
        product.price, product.discounted_price, product.thumbnail
SQL;

        $pagination = $this->model
            ->selectRaw($columns, [
                $filters->get('description_length', 200),
                $filters->get('description_length', 200),
            ])
            ->whereHas('category', function (Builder $query) use ($id) {
                return $query
                    ->join('department', 'category.department_id', 'department.department_id')
                    ->where('department.department_id', $id);
            });

        if ($filters->has('size') && !empty($filters->get('size'))) {
            $pagination->join('product_attribute', 'product.product_id', 'product_attribute.product_id');
            $pagination = $pagination->whereIn('product_attribute.attribute_value_id', explode(',', $filters->get('size')));
        }

        if ($filters->has('min') || $filters->has('max')) {
            $pagination = $pagination->whereBetween(\DB::raw('COALESCE(NULLIF(product.discounted_price, 0), product.price)'), [$filters->get('min'), $filters->get('max')]);
        }

        return $pagination->paginate($filters->get('limit', 15));
    }

    public function locations(int $id)
    {
        return $this->model->with('category.departments')
            ->find($id)->category
            ->map(function ($item) {
                return [
                    "category_id" => $item->category_id,
                    "category_name" => $item->name,
                    "department_id" => $item->departments->department_id,
                    "department_name" => $item->departments->name
                ];
            });
    }

    public function reviews(int $id)
    {
        return $this->model->with('reviews.customer')
            ->find($id)->reviews
            ->map(function ($item) {
                return [
                    "name" => $item->customer->name,
                    "review" => $item->review,
                    "rating" => $item->rating,
                    "created_on" => $item->created_on->format('Y-m-d H:i:s')
                ];
            });
    }

    public function review(int $id, Collection $collection = null)
    {
        $collection->put('created_on', date('Y-m-d H:i:s'));
        //$collection->put('product_id', $id);
        //die(print_r($collection->all()));
        $this->model->find($id)->reviews()->create($collection->only('product_id', 'review', 'rating', 'customer_id', 'created_on')->all());

        return $this->model;
    }

    /**
     * @param Collection $data
     * @return Model
     */
    public function add(Collection $data): Model
    {
        // TODO: Implement add() method.
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
