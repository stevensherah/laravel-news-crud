<?php

namespace Sevenpluss\NewsCrud\Criteria\Post;

use Illuminate\Database\Eloquent\Builder;
use Sevenpluss\NewsCrud\Criteria\Criteria;
use Sevenpluss\NewsCrud\Criteria\Contracts\CriteriaInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\RepositoryInterface;

/**
 * Class ByCategoryId
 * @package Sevenpluss\NewsCrud\Criteria\Post
 */
class ByCategoryId extends Criteria implements CriteriaInterface
{
    /**
     * @var int
     */
    protected $category_id;

    /**
     * ByCategoryId constructor.
     * @param int $category_id
     */
    public function __construct(int $category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Post $model
     * @param RepositoryInterface $repository
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $model, RepositoryInterface $repository): \Illuminate\Database\Eloquent\Builder
    {
        return $model->whereCategoryId($this->category_id);
    }
}
