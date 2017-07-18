<?php

namespace Sevenpluss\NewsCrud\Repositories;

use Sevenpluss\NewsCrud\Repositories\Contracts\CategoryRepositoryInterface;
use Sevenpluss\NewsCrud\Models\Category;
use Sevenpluss\NewsCrud\Criteria\Category\Active as CriteriaActive;

/**
 * Class CategoryRepository
 * @package Sevenpluss\NewsCrud\Repositories
 */
class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{
    /**
     * @var \Sevenpluss\NewsCrud\Models\Category
     */
    protected $model;

    /**
     * @return string
     */
    public function getModel(): string
    {
        return Category::class;
    }

    /**
     * @param array $columns
     * @return \Illuminate\Support\Collection|static[]
     */
    public function active(array $columns = ['*']): \Illuminate\Support\Collection
    {
        $this->pushCriteria($this->app->make(CriteriaActive::class));

        return parent::orderBy('sorted', 'desc')->all($columns);
    }
}
