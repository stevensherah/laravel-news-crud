<?php

namespace Sevenpluss\NewsCrud\Criteria\Post;

use Illuminate\Database\Eloquent\Builder;
use Sevenpluss\NewsCrud\Criteria\Criteria;
use Sevenpluss\NewsCrud\Criteria\Contracts\CriteriaInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\RepositoryInterface;

/**
 * Class ByUserId
 * @package Sevenpluss\NewsCrud\Criteria\Post
 */
class ByUserId extends Criteria implements CriteriaInterface
{
    /**
     * @var int
     */
    protected $user_id;

    /**
     * ByUserId constructor.
     * @param int $user_id
     */
    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Post $model
     * @param RepositoryInterface $repository
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $model, RepositoryInterface $repository): \Illuminate\Database\Eloquent\Builder
    {
        return $model->whereUserId($this->user_id);
    }
}
