<?php

namespace Sevenpluss\NewsCrud\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * Class Latest
 * @package Sevenpluss\NewsCrud\Models\Scopes
 */
trait Latest
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLatest(Builder $query):\Illuminate\Database\Eloquent\Builder
    {
        return $query->whereNotNull('published_at')->orderBy('published_at', 'desc');
    }
}