<?php

namespace Sevenpluss\NewsCrud\Repositories\Contracts;

/**
 * Interface TagRepositoryInterface
 * @package Sevenpluss\NewsCrud\Repositories\Contracts
 */
interface TagRepositoryInterface extends RepositoryInterface
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function activeHasPosts():\Illuminate\Support\Collection;
}
