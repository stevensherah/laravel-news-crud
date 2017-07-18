<?php

namespace Sevenpluss\NewsCrud\Criteria\Post;

use Illuminate\Database\Eloquent\Builder;
use Sevenpluss\NewsCrud\Criteria\Criteria;
use Sevenpluss\NewsCrud\Criteria\Contracts\CriteriaInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\RepositoryInterface;

/**
 * Class ByTag
 * @package Sevenpluss\NewsCrud\Criteria\Post
 */
class ByTag extends Criteria implements CriteriaInterface
{
    /**
     * @var string
     */
    protected $tag;

    /**
     * ByTag constructor.
     * @param string $tag
     */
    public function __construct(string $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $model
     * @param RepositoryInterface $repository
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $model, RepositoryInterface $repository): \Illuminate\Database\Eloquent\Builder
    {
        return $model->whereHas('tags', function (Builder $query) {
            $query->whereKey($this->tag);
        });
    }
}