<?php

namespace Sevenpluss\NewsCrud\Criteria\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Sevenpluss\NewsCrud\Repositories\Contracts\RepositoryInterface;

/**
 * Interface CriteriaInterface
 * @package Sevenpluss\NewsCrud\Criteria\Contracts
 */
interface CriteriaInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $model
     * @param RepositoryInterface $repository
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $model, RepositoryInterface $repository):\Illuminate\Database\Eloquent\Builder;
}
