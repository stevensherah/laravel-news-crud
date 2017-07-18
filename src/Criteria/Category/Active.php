<?php

namespace Sevenpluss\NewsCrud\Criteria\Category;

use Illuminate\Database\Eloquent\Builder;
use Sevenpluss\NewsCrud\Criteria\Criteria;
use Sevenpluss\NewsCrud\Criteria\Contracts\CriteriaInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\RepositoryInterface;

/**
 * Class Active
 * @package Sevenpluss\NewsCrud\Criteria\Category
 */
class Active extends Criteria implements CriteriaInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Category $model
     * @param RepositoryInterface $repository
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $model, RepositoryInterface $repository): \Illuminate\Database\Eloquent\Builder
    {
        return $model->active();
    }
}
