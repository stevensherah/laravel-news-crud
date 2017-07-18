<?php

namespace Sevenpluss\NewsCrud\Repositories\Contracts;

use Illuminate\Http\Request;

/**
 * Interface PostRepositoryInterface
 * @package Sevenpluss\NewsCrud\Repositories\Contracts
 */
interface PostRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int $id
     * @return int
     */
    public function viewsIncrement(int $id): int;

    /**
     * @param int $id
     * @return \Sevenpluss\NewsCrud\Models\Post|null
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show(int $id): \Sevenpluss\NewsCrud\Models\Post;

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateRequest(Request $request): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    /**
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function popularPageMain(int $limit): \Illuminate\Support\Collection;

    /**
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function latestPageMain(int $limit): \Illuminate\Support\Collection;
}
