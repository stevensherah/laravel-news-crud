<?php

namespace Sevenpluss\NewsCrud\Repositories;

use Illuminate\Database\Eloquent\Relations\Relation;
use Sevenpluss\NewsCrud\Repositories\Contracts\UserRepositoryInterface;
use Sevenpluss\NewsCrud\Models\User;

/**
 * Class UserRepository
 * @package Sevenpluss\NewsCrud\Repositories
 */
class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * @var \Sevenpluss\NewsCrud\Models\User
     */
    protected $model;

    /**
     * @return string
     */
    public function getModel(): string
    {
        return User::class;
    }

    /**
     * @param int $id
     * @return \Sevenpluss\NewsCrud\Models\User
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show(int $id): User
    {
        return $this->model->whereKey($id)->with([
            'posts' => function (Relation $query) {
                $query->select(['user_id']);
            },
            'comments' => function (Relation $query) {
                $query->select(['user_id']);
            }
        ])->firstOrFail(['id', 'name']);
    }
}
