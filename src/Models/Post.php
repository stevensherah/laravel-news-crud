<?php

namespace Sevenpluss\NewsCrud\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Sevenpluss\NewsCrud\Models\Scopes\Published as ScopePublished;
use Sevenpluss\NewsCrud\Models\Scopes\Latest as ScopeLatest;

/**
 * Class Post
 *
 * @package Sevenpluss\NewsCrud\Models
 * @property int $id
 * @property string $slug
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $published_at
 * @property mixed $category_id
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property string $name
 * @property string $summary
 * @property string|null $story
 * @property int $views
 * @property-read \Sevenpluss\NewsCrud\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\Sevenpluss\NewsCrud\Models\Comment[] $comments
 * @property-read bool $is_published_today
 * @property-read array $manage_buttons
 * @property-read \Carbon\Carbon|null $published_safe
 * @property-read string $url
 * @property-read \Illuminate\Database\Eloquent\Collection|\Sevenpluss\NewsCrud\Models\Tag[] $tags
 * @property-read \Sevenpluss\NewsCrud\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Post latest()
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Post published()
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Post whereCategoryId(int $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Post whereDescription(string $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Post whereId(int $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Post whereKeywords(string $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Post whereName(string $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Post whereSlug(string $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Post whereStory(string $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Post whereSummary(string $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Post whereTitle(string $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Post whereUserId(int $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Post whereViews(int $value)
 * @mixin \Eloquent
 * @property-read \Sevenpluss\NewsCrud\Models\Category|null $categories
 */
class Post extends Model
{
    use ScopePublished, ScopeLatest;

    /**
     * @var string
     */
    protected $table = 'posts';

    /**
     * @var array
     */
    protected $dates = ['published_at'];

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'interger',
        'slug' => 'string',
        'user_id' => 'interger',
        'category_id' => 'interger',
        'title' => 'string',
        'description' => 'string',
        'keywords' => 'string',
        'name' => 'string',
        'summary' => 'string',
        'store' => 'string',

        'url' => 'string',
        'is_published_today' => 'boolean',
        'manage_buttons' => 'array',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'url' => null,
        'is_published_today' => false,
        'published_safe' => null,
        'manage_buttons' => null,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', $this->getKeyName());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_slug');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return $this->getUrl();
    }

    /**
     * @return bool
     */
    public function getIsPublishedTodayAttribute(): bool
    {
        $time_now = Carbon::now();
        $is_today = $this->published_at->diff($time_now)->days < 1;

        return boolval($is_today);
    }

    /**
     * @return string
     */
    public function getPublishedSafeAttribute(): string
    {
        return $this->published_at->format(trans($this->is_published_today ? 'news::config.time' : 'news::config.datetime'));
    }

    /**
     * @return array
     */
    public function getManageButtonsAttribute(): array
    {
        return [
            'edit' => route('news.edit', ['id' => $this->id, 'slug' => $this->slug], false),
            'delete' => true,
        ];
    }

    /**
     * @param bool $absolute
     * @return string
     */
    public function getUrl(bool $absolute = false): string
    {
        return route('news.show', ['id' => $this->id, 'slug' => $this->slug], $absolute);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return !is_null($this->title) ? $this->title : $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return !is_null($this->description) ? $this->description : str_limit($this->summary, 155, '');
    }
}
