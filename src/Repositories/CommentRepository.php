<?php

namespace Sevenpluss\NewsCrud\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\Relation;
use Sevenpluss\NewsCrud\Repositories\Contracts\CommentRepositoryInterface;
use Sevenpluss\NewsCrud\Models\Comment;
use Sevenpluss\NewsCrud\Criteria\Common\LimitPerPage as CriteriaLimitPerPage;
use Sevenpluss\NewsCrud\Criteria\Comment\Latest as CriteriaLatest;
use Sevenpluss\NewsCrud\Criteria\Comment\ByPostId as CriteriaPostId;
use Sevenpluss\NewsCrud\Criteria\Comment\UserId as CriteriaUserId;

/**
 * Class CategoryRepository
 * @package Sevenpluss\NewsCrud\Repositories
 */
class CommentRepository extends AbstractRepository implements CommentRepositoryInterface
{
    /**
     * @var \Sevenpluss\NewsCrud\Models\Comment
     */
    protected $model;

    /**
     * @return string
     */
    public function getModel(): string
    {
        return Comment::class;
    }

    /**
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function latestPageMain(int $limit = 5): \Illuminate\Support\Collection
    {
        $this->pushCriteria($this->app->make(CriteriaLatest::class));
        $this->pushCriteria($this->app->makeWith(CriteriaLimitPerPage::class, ['take' => $limit]));

        return $this->with([
            'user' => function (Relation $query) {
                $query->select(['id', 'name']);
            },
            'post' => function (Relation $query) {
                $query->select(['id', 'slug'])->published();
            }
        ])->orderBy('created_at', 'desc')->all([
            'id',
            'user_id',
            'post_id',
            'name',
            'created_at',
            'content'
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateRequest(Request $request): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $appends = [];

        if ($request->has('post_id')) {

            $this->pushCriteria($this->app->makeWith(CriteriaPostId::class, ['post_id' => $request->input('post_id')]));

            $appends['post_id'] = $request->input('post_id');
        }


        if ($request->has('user_id')) {

            $this->pushCriteria($this->app->makeWith(CriteriaUserId::class, ['user_id' => $request->input('user_id')]));

            $appends['user_id'] = $request->input('user_id');
        }


        $comments = parent::with([
            'user' => function (Relation $query) {
                $query->select(['id', 'name']);
            },
            'post' => function (Relation $query) {
                $query->select(['id', 'slug']);
            }
        ])->orderBy('created_at', 'desc')->paginate(15, [
            'id',
            'post_id',
            'user_id',
            'name',
            'created_at',
            'content'
        ]);


        foreach ($appends as $key => $value) {
            $comments->appends($key, $value);
        }

        return $comments;
    }
}
