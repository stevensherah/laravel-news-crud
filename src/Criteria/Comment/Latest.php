<?php

namespace Sevenpluss\NewsCrud\Criteria\Comment;

use Illuminate\Database\Eloquent\Builder;
use Sevenpluss\NewsCrud\Criteria\Criteria;
use Sevenpluss\NewsCrud\Criteria\Contracts\CriteriaInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\RepositoryInterface;

/**
 * Class Latest
 * @package Sevenpluss\NewsCrud\Criteria\Comment
 */
class Latest extends Criteria implements CriteriaInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $model
     * @param RepositoryInterface $repository
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $model, RepositoryInterface $repository): \Illuminate\Database\Eloquent\Builder
    {
        return $model->whereNotNull('updated_at');
    }
}
