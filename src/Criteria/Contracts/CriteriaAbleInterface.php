<?php

namespace Sevenpluss\NewsCrud\Criteria\Contracts;

use Sevenpluss\NewsCrud\Criteria\Contracts\CriteriaInterface as Criteria;

/**
 * Interface CriteriaInterface
 * @package Sevenpluss\NewsCrud\Criteria\Contracts
 */
interface CriteriaAbleInterface
{
    /**
     * @param bool $status
     * @return $this
     */
    public function skipCriteria(bool $status = true);

    /**
     * @return \Illuminate\Support\Collection
     */
    public function resetCriteria(): \Illuminate\Support\Collection;

    /**
     * Pop Criteria
     * @param Criteria $criteria
     * @return $this
     */
    public function popCriteria(Criteria $criteria);

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getCriteria(): \Illuminate\Support\Collection;

    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function getByCriteria(Criteria $criteria);

    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function pushCriteria(Criteria $criteria);

    /**
     * @return $this
     */
    public function applyCriteria();
}
