<?php

namespace Sevenpluss\NewsCrud\Repositories\Contracts;

/**
 * Interface RepositoryInterface
 * @package Sevenpluss\NewsCrud\Repositories\Contracts
 */
interface RepositoryInterface
{
    /**
     * @param array $columns
     * @return \Illuminate\Support\Collection
     */
    public function all(array $columns = ['*']): \Illuminate\Support\Collection;

    /**
     * @param int|null $perPage
     * @param array $columns
     * @param string $pageName
     * @param int|null $page
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function simplePaginate($perPage, $columns, $pageName, $page): \Illuminate\Contracts\Pagination\Paginator;

    /**
     * @param int|null $perPage
     * @param array $columns
     * @param string $pageName
     * @param int|null $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(
        $perPage = 12,
        $columns = ['*'],
        $pageName = 'page',
        $page = null
    ): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    /**
     * @param int|string|array $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function find($id, array $columns = ['*']);

    /**
     * @param string $field
     * @param mixed $value
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|static[]|static|null
     */
    public function findBy(string $field, $value, array $columns = ['*']): \Illuminate\Support\Collection;

    /**
     * @param int|string $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail($id, array $columns = ['*']);

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data);

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function newInstance(): \Illuminate\Database\Eloquent\Model;

    /**
     * @param array $attributes
     * @param array $options
     * @return bool
     */
    public function update(array $attributes = [], array $options = []): bool;

    /**
     * @param int|string|array $id
     * @return bool
     */
    public function delete($id): bool;

    /**
     * @param string $relation
     * @return $this
     */
    public function has(string $relation);

    /**
     * @param array|string $relations
     * @return $this
     */
    public function with($relations);

    /**
     * @param  mixed $relations
     * @return $this
     */
    public function withCount($relations);

    /**
     * @param string $relation
     * @param \Closure $closure
     * @return $this
     */
    public function whereHas(string $relation, \Closure $closure);

    /**
     * Add an "order by" clause to the query.
     *
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function orderBy(string $column, string $direction = 'asc');

    /**
     * Set the hidden attributes for the model.
     *
     * @param array $fields
     * @return $this
     */
    public function hidden(array $fields);

    /**
     * Set the visible attributes for the model.
     *
     * @param array $fields
     * @return $this
     */
    public function visible(array $fields);
}
