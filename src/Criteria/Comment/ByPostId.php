<?php

namespace Sevenpluss\NewsCrud\Criteria\Comment;

use Illuminate\Database\Eloquent\Builder;
use Sevenpluss\NewsCrud\Criteria\Criteria;
use Sevenpluss\NewsCrud\Criteria\Contracts\CriteriaInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\RepositoryInterface;

/**
 * Class ByPostId
 * @package Sevenpluss\NewsCrud\Criteria\Comment
 */
class ByPostId extends Criteria implements CriteriaInterface
{
    /**
     * @var int
     */
    protected $post_id;

    /**
     * ByPostId constructor.
     * @param int $post_id
     */
    public function __construct(int $post_id)
    {
        $this->post_id = $post_id;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $model
     * @param RepositoryInterface $repository
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $model, RepositoryInterface $repository): \Illuminate\Database\Eloquent\Builder
    {
        return $model->whereNotNull('post_id')->where('post_id', $this->post_id);
    }
}
