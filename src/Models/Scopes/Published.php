<?php

namespace Sevenpluss\NewsCrud\Models\Scopes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Published
 * @package Sevenpluss\NewsCrud\Models\Scopes
 */
trait Published
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished(Builder $query):\Illuminate\Database\Eloquent\Builder
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', Carbon::now());
    }
}
