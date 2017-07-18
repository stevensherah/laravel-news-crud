<?php

namespace Sevenpluss\NewsCrud\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 *
 * @package Sevenpluss\NewsCrud\Models
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property string $email
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $content
 * @property-read \Sevenpluss\NewsCrud\Models\Post $post
 * @property-read \Sevenpluss\NewsCrud\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Comment latest()
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Comment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Comment whereEmail(string $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Comment whereId(int $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Comment whereName(string $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Comment wherePostId(int $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Sevenpluss\NewsCrud\Models\Comment whereUserId(int $value)
 * @mixin \Eloquent
 */
class Comment extends Model
{
    /**
     * @var string
     */
    protected $table = 'comments';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'post_id' => 'integer',
        'user_id' => 'integer',
        'email' => 'string',
        'name' => 'string',
        'content' => 'string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
