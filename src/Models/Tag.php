<?php

namespace Sevenpluss\NewsCrud\Models;

use Illuminate\Database\Eloquent\Model;
use Sevenpluss\NewsCrud\Models\Scopes\Active as traitScopeActive;

/**
 * Class Tag
 *
 * @package Sevenpluss\NewsCrud\Models
 * @property string $slug
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $name
 * @property bool $active
 * @property-read bool $is_active
 * @property-read string $url
 * @property-read \Illuminate\Database\Eloquent\Collection|\Sevenpluss\NewsCrud\Models\Post[] $posts
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Tag active()
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Tag whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Tag whereName(string $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Tag whereSlug(string $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tag extends Model
{
    use traitScopeActive;

    /**
     * @var string
     */
    protected $table = 'tags';

    /**
     * @var string
     */
    protected $primaryKey = 'slug';

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'active'];

    /**
     * @var array
     */
    protected $casts = [
        'slug' => 'string',
        'name' => 'string',
        'active' => 'boolean',

        'url' => 'string',
        'is_active' => 'boolean',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'url' => null,
        'is_active' => false,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tags', 'tag_slug', 'post_id');
    }

    /**
     * @param int|string|null|bool $value
     * @return void
     */
    public function setActiveAttribute($value): void
    {
        if ((is_string($value) && strtolower($value) == 'yes')
            || (is_bool($value) && $value == true)
            || (is_int($value) && $value > 0)
        ) {
            $this->attributes['active'] = 1;
        } else {
            $this->attributes['active'] = null;
        }
    }

    /**
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return $this->getUrl();
    }

    /**
     * @param string|null $tag
     * @return bool
     */
    public function getIsActive(?string $tag): bool
    {
        $is_active = !is_null($tag) && $tag == $this->slug;

        return boolval($is_active);
    }

    /**
     * @param bool $absolute
     * @return string
     */
    public function getUrl(bool $absolute = false): string
    {
        return route('tags.show', ['slug' => $this->slug], $absolute);
    }

}
