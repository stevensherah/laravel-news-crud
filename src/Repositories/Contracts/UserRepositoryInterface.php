<?php

namespace Sevenpluss\NewsCrud\Repositories\Contracts;

/**
 * Interface UserRepositoryInterface
 * @package Sevenpluss\NewsCrud\Repositories\Contracts
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int $id
     * @return \Sevenpluss\NewsCrud\Models\User
     */
    public function show(int $id): \Sevenpluss\NewsCrud\Models\User;
}
