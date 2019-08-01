<?php


namespace Turing\Category\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;
use Turing\Backend\Repository\RepositoryInterface;
use Turing\Category\Model\Category;

/**
 * Class CategoryRepository
 * @package Turing\Category\Repository
 */
class CategoryRepository implements RepositoryInterface
{

    /**
     * @var Category|Model|\Illuminate\Database\Query\Builder|Builder
     */
    private $model;

    public function __construct(Category $model)
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
    public function getCategoriesInDepartment(int $id, Collection $filters = null): Collection
    {
        return $this->model->whereHas('departments', function ($query) use ($id) {
            return $query->where('department_id', $id);
        })->get();
    }

    /**
     * @param int $id
     * @param Collection|null $filters
     * @return Collection
     */
    public function getCategoriesInProduct(int $id, Collection $filters = null): Collection
    {
        return $this->model->whereHas('products', function ($query) use ($id) {
            return $query->where('product_category.product_id', $id);
        })->get();
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
