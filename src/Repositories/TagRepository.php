<?php

namespace Sevenpluss\NewsCrud\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Sevenpluss\NewsCrud\Repositories\Contracts\TagRepositoryInterface;
use Sevenpluss\NewsCrud\Models\Tag;

/**
 * Class CategoryRepository
 * @package Sevenpluss\NewsCrud\Repositories
 */
class TagRepository extends AbstractRepository implements TagRepositoryInterface
{
    /**
     * @var \Sevenpluss\NewsCrud\Models\Tag
     */
    protected $model;

    /**
     * @return string
     */
    public function getModel():string
    {
        return Tag::class;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function activeHasPosts():\Illuminate\Support\Collection
    {
        return $this->model->whereHas('posts', function (Builder $query) {
            $query->select(['id']);
        })->active()->orderBy('updated_at', 'desc')
            ->get(['slug', 'name']);
    }
}
