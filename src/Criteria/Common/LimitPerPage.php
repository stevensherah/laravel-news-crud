<?php

namespace Sevenpluss\NewsCrud\Criteria\Common;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Sevenpluss\NewsCrud\Criteria\Criteria;
use Sevenpluss\NewsCrud\Criteria\Contracts\CriteriaInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\RepositoryInterface;

/**
 * Class LimitSkipTake
 * @package Sevenpluss\NewsCrud\Criteria\Common
 */
class LimitPerPage extends Criteria implements CriteriaInterface
{
    /**
     * @var int
     */
    protected $take = 1;

    /**
     * @var int
     */
    protected $skip = 0;

    /**
     * TakeSkip constructor.
     * @param int $take
     * @param int $skip
     */
    public function __construct(int $take = 1, int $skip = 0)
    {
        $this->take = $take;
        $this->skip = $skip;
    }

    /**
     * @param Model|\Illuminate\Database\Eloquent\Builder $model
     * @param RepositoryInterface $repository
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $model, RepositoryInterface $repository): \Illuminate\Database\Eloquent\Builder
    {
        return $model->skip($this->skip)->take($this->take);
    }
}
