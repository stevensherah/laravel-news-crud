<?php

namespace Sevenpluss\NewsCrud\Repositories\Contracts;

use Illuminate\Http\Request;

/**
 * Interface CommentRepositoryInterface
 * @package Sevenpluss\NewsCrud\Repositories\Contracts
 */
interface CommentRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function latestPageMain(int $limit = 5): \Illuminate\Support\Collection;

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateRequest(Request $request): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
}
