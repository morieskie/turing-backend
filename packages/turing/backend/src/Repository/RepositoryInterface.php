<?php

namespace Turing\Backend\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;
use League\Fractal\Resource\Item as ResourceItem;

/**
 * Interface BackendInterface
 * @package Turing\Backend\Repository
 */
interface RepositoryInterface
{
    /**
     * @param int $id
     * @param Collection|null $filters
     * @return ResourceItem
     */
    public function item(int $id, Collection $filters = null): Model;

    /**
     * @param Collection|null $filters
     * @return AbstractPaginator
     */
    public function collection(Collection $filters = null): Paginator;

    /**
     * @param Collection $data
     * @return Model
     */
    public function add(Collection $data): Model;

    /**
     * @param int $id
     * @param Collection $data
     * @return Model
     */
    public function update(int $id, Collection $data): Model;

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);
}
