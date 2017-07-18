<?php

namespace Sevenpluss\NewsCrud\Models;

use App\User as AppUser;

/**
 * Class User
 *
 * @package Sevenpluss\NewsCrud\Models
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Sevenpluss\NewsCrud\Models\Comment[] $comments
 * @property-read string $url
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Sevenpluss\NewsCrud\Models\Post[] $posts
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\User whereEmail(string $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\User whereId(int $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\User whereName(string $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read string $url_comments
 * @property-read string $url_posts
 */
class User extends AppUser
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',

        'url' => 'string',
        'url_posts' => 'string',
        'url_comments' => 'string',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'url' => null,
        'url_posts' => null,
        'url_comments' => null,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', $this->getKeyName());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', $this->getKeyName());
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
        return route('user.show', [$this->getKeyName() => $this->{$this->getKeyName()}], $absolute);
    }

    /**
     * @return string
     */
    public function getUrlPostsAttribute(): string
    {
        return $this->getUrlPosts();
    }

    /**
     * @param bool $absolute
     * @return string
     */
    public function getUrlPosts(bool $absolute = false): string
    {
        return route('news.index', ['user_id' => $this->{$this->getKeyName()}], $absolute);
    }

    /**
     * @return string
     */
    public function getUrlCommentsAttribute(): string
    {
        return $this->getUrlComments();
    }

    /**
     * @param bool $absolute
     * @return string
     */
    public function getUrlComments(bool $absolute = false): string
    {
        return route('comments.index', ['user_id' => $this->{$this->getKeyName()}], $absolute);
    }
}
