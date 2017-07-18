<?php

namespace Sevenpluss\NewsCrud\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class Active
 * @package Sevenpluss\NewsCrud\Models\Scopes
 */
trait Active
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query):\Illuminate\Database\Eloquent\Builder
    {
        return $query->whereNotNull('active');
    }
}
