<?php


namespace Turing\Shipping\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;
use Turing\Backend\Repository\RepositoryInterface;
use Turing\Shipping\Model\Shipping;
use Turing\Shipping\Model\ShippingRegion;

/**
 * Class ShippingRepository
 * @package Turing\Shipping\Repository
 */
class ShippingRepository implements RepositoryInterface
{

    /**
     * @var Shipping|Model|\Illuminate\Database\Query\Builder|Builder
     */
    private $model;

    public function __construct(ShippingRegion $model)
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
     * @return mixed
     */
    public function getRegionsByShippingRegionId(int $id)
    {
        return $this->model->with('shippings')->findOrFail($id)->shippings;
    }

    public function getShipping(int $id)
    {
        return Shipping::findOrFail($id);
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
