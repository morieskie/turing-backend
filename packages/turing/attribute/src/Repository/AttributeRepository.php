<?php


namespace Turing\Attribute\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;
use Turing\Backend\Repository\RepositoryInterface;
use Turing\Attribute\Model\Attribute;

/**
 * Class AttributeRepository
 * @package Turing\Attribute\Repository
 */
class AttributeRepository implements RepositoryInterface
{

    /**
     * @var Attribute|Model|\Illuminate\Database\Query\Builder|Builder
     */
    private $model;

    public function __construct(Attribute $model)
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
     * @param Collection|null $filters
     * @return Paginator
     */
    public function collection(Collection $filters = null): Paginator
    {
        $pagination = $this->model->paginate($filters->get('limit', 20));

        return $pagination;
    }

    /**
     * @param int $id
     * @param Collection|null $filters
     * @return Collection
     */
    public function getAttributeValues(int $id, Collection $filters = null): Collection
    {
       return Attribute::with('values')->find($id)->values()->select(['attribute_value_id', 'value'])->get();
    }

    /**
     * @param int $id
     * @param Collection|null $filters
     * @return Collection
     */
    public function getAttributesInProduct(int $id, Collection $filters = null): Collection
    {
        $collection = Attribute::with('values')
            ->whereHas('products', function ($query) use ($id) {
                return $query->where('product_attribute.product_id', $id);
            })
            ->get();

        $collection->transform(function ($item) {
            return $item->values->map(function ($value) use ($item) {
                return [
                    "attribute_name" => $item->name,
                    "attribute_value_id" => $value->attribute_value_id,
                    "attribute_value" => $value->value
                ];
            });
        });

        return $collection->flatten(1);
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
