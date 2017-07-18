<?php

namespace Sevenpluss\NewsCrud\Models;

use Illuminate\Database\Eloquent\Model;
use Sevenpluss\NewsCrud\Models\Scopes\Active as traitScopeActive;

/**
 * Class Category
 *
 * @package Sevenpluss\NewsCrud\Models
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $slug
 * @property string $name
 * @property bool $active
 * @property int $sorted
 * @property-read string $url
 * @property-read \Sevenpluss\NewsCrud\Models\Post $post
 * @property-read \Illuminate\Database\Eloquent\Collection|\Sevenpluss\NewsCrud\Models\Post[] $posts
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Category active()
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Category whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Category whereId(int $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Category whereName(string $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Category whereSlug(string $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Category whereSorted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use traitScopeActive;

    /**
     * @var string
     */
    protected $table = 'categories';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'slug' => 'string',
        'name' => 'string',
        'active' => 'boolean',
        'sorted' => 'integer',

        'url' => 'string',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'url' => null,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class, $this->getKeyName(), 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id', $this->getKeyName());
    }

    /**
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return $this->getUrl();
    }

    /**
     * @param bool $absolute
     * @return string
     */
    public function getUrl(bool $absolute = false): string
    {
        return route('category.show', ['slug' => $this->slug], $absolute);
    }
}
