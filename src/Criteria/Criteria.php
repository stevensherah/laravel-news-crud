<?php

namespace Sevenpluss\NewsCrud\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Sevenpluss\NewsCrud\Repositories\Contracts\RepositoryInterface;

/**
 * Class Criteria
 * @package Sevenpluss\NewsCrud\Criteria
 */
abstract class Criteria
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $model
     * @param RepositoryInterface $repository
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public abstract function apply(
        Builder $model,
        RepositoryInterface $repository
    ): \Illuminate\Database\Eloquent\Builder;
}
