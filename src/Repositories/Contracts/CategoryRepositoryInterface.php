<?php

namespace Sevenpluss\NewsCrud\Repositories\Contracts;

/**
 * Interface CategoryRepositoryInterface
 * @package Sevenpluss\NewsCrud\Repositories\Contracts
 */
interface CategoryRepositoryInterface extends RepositoryInterface
{
    /**
     * @param array $columns
     * @return \Illuminate\Support\Collection|static[]
     */
    public function active(array $columns = ['*']): \Illuminate\Support\Collection;
}
