<?php

namespace Sevenpluss\NewsCrud\Criteria\Post;

use Illuminate\Database\Eloquent\Builder;
use Sevenpluss\NewsCrud\Criteria\Criteria;
use Sevenpluss\NewsCrud\Criteria\Contracts\CriteriaInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\RepositoryInterface;

/**
 * Class Latest
 * @package Sevenpluss\NewsCrud\Criteria\Post
 */
class Latest extends Criteria implements CriteriaInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Post $model
     * @param RepositoryInterface $repository
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $model, RepositoryInterface $repository): \Illuminate\Database\Eloquent\Builder
    {
        return $model->latest();
    }
}
