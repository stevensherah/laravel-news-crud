<?php

namespace Sevenpluss\NewsCrud\Criteria\Comment;

use Illuminate\Database\Eloquent\Builder;
use Sevenpluss\NewsCrud\Criteria\Criteria;
use Sevenpluss\NewsCrud\Criteria\Contracts\CriteriaInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\RepositoryInterface;

/**
 * Class UserId
 * @package Sevenpluss\NewsCrud\Criteria\Comment
 */
class UserId extends Criteria implements CriteriaInterface
{
    /**
     * @var int
     */
    protected $user_id;

    /**
     * ByPostId constructor.
     * @param int $user_id
     */
    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $model
     * @param RepositoryInterface $repository
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $model, RepositoryInterface $repository): \Illuminate\Database\Eloquent\Builder
    {
        return $model->where('user_id', $this->user_id);
    }
}
