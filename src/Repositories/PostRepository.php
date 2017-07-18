<?php

namespace Sevenpluss\NewsCrud\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Sevenpluss\NewsCrud\Repositories\Contracts\PostRepositoryInterface;
use Sevenpluss\NewsCrud\Models\Post;
use Sevenpluss\NewsCrud\Criteria\Common\LimitPerPage as CriteriaLimitPerPage;
use Sevenpluss\NewsCrud\Criteria\Post\Published as CriteriaPostPublished;
use Sevenpluss\NewsCrud\Criteria\Post\ByCategoryId as CriteriaPostByCategoryId;
use Sevenpluss\NewsCrud\Criteria\Post\ByTag as CriteriaPostByTag;
use Sevenpluss\NewsCrud\Criteria\Post\ByUserId as CriteriaPostByUserId;

/**
 * Class PostRepository
 * @package Sevenpluss\NewsCrud\Repositories
 */
class PostRepository extends AbstractRepository implements PostRepositoryInterface
{
    /**
     * @var \Sevenpluss\NewsCrud\Models\Post
     */
    protected $model;

    /**
     * @return string
     */
    public function getModel(): string
    {
        return Post::class;
    }

    /**
     * @param int $id
     * @return int
     */
    public function viewsIncrement(int $id): int
    {
        return $this->model->whereId($id)->increment('views');
    }

    /**
     * @param int $id
     * @return \Illuminate\Support\Collection|\Sevenpluss\NewsCrud\Models\Post
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show(int $id): \Sevenpluss\NewsCrud\Models\Post
    {
        return $this->model->with([
                'tags' => function (Relation $query) {
                    $query->select(['slug', 'name']);
                },
                'user' => function (Relation $query) {
                    $query->select(['id', 'name']);
                },
                'category' => function (Relation $query) {
                    $query->select(['id', 'slug', 'name']);
                }
            ])
            ->findOrFail($id, [
                'id',
                'slug',
                'user_id',
                'created_at',
                'updated_at',
                'published_at',
                'category_id',
                'title',
                'description',
                'keywords',
                'name',
                'summary',
                'story',
                'views'
            ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateRequest(Request $request):\Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $appends = [];

        if ($request->has('limit') && $request->input('limit') <= 100) {

            $limit = $request->input('limit');

            $appends['limit'] = $limit;

        } else {
            $limit = 15;
        }


        $this->resetCriteria();
        $this->pushCriteria(new CriteriaPostPublished);

        if ($request->has('category_id') && $request->route()->getName() != 'category.show') {

            if ($request->input('route') != 'category.show') {
                $appends['category_id'] = $request->input('category_id');
            }

            $this->pushCriteria($this->app->makeWith(CriteriaPostByCategoryId::class,
                ['category_id' => $request->input('category_id')]));
        }


        if ($request->has('tag') && $request->route()->getName() != 'tags.show') {

            if ($request->input('route') != 'tags.show') {
                $appends['tag'] = $request->input('tag');
            }

            $this->pushCriteria($this->app->makeWith(CriteriaPostByTag::class,
                ['tag' => $request->input('tag')]));
        }

        if (in_array('tags.show', [$request->route()->getName(), $request->input('route')])) {

            $this->model->whereHas('tags', function (Builder $query) use ($request) {

                $tag = $request->has('tag') ? $request->input('tag') : $request->input('slug');

                $query->select(['slug'])->where('slug', $tag);
            });
        }


        if ($request->has('user_id')) {

            $appends['user_id'] = $request->input('user_id');

            $this->pushCriteria($this->app->makeWith(CriteriaPostByUserId::class,
                ['user_id' => $request->input('user_id')]));
        }



        $posts = parent::with([
            'tags' => function (Relation $query) {
                $query->select(['slug', 'name']);
            },
            'user' => function (Relation $query) {
                $query->select(['id', 'name']);
            },
            'category' => function (Relation $query) {
                $query->select(['id', 'slug', 'name']);
            }
        ])
            ->orderBy('published_at', 'desc')->paginate($limit, [
                'id',
                'slug',
                'user_id',
                'published_at',
                'category_id',
                'name',
                'summary',
            ], 'page', $request->input('page'));


        foreach ($appends as $key => $value) {
            $posts->appends($key, $value);
        }


        // check ajax queries and set url path for paginate
        if ($request->has('route')) {

            $route_query = [];

            switch ($request->has('route')) {

                case 'tags.show' && $request->has('tag'):
                    $route_name = $request->input('route');
                    $route_query = ['slug' => $request->input('tag')];
                    break;

                case 'category.show':
                    $route_name = $request->input('route');
                    $route_query = ['slug' => $posts->first()->category->slug];
                    break;

                default:
                    $route_name = 'news.index';
                    
                    if ($request->has('user_id')) {
                        $route_query['user_id'] = $request->input('user_id');
                    }

            }

            $posts->setPath(route($route_name, $route_query, false));
        }


        return $posts;
    }

    /**
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function popularPageMain(int $limit = 5):\Illuminate\Support\Collection
    {
        $this->resetCriteria();
        $this->pushCriteria(new CriteriaPostPublished);
        $this->pushCriteria($this->app->makeWith(CriteriaLimitPerPage::class, ['take' => $limit]));

        $model = $this->with([
            'tags' => function (Relation $query) {
                $query->select(['slug', 'name']);
            },
            'user' => function (Relation $query) {
                $query->select(['id', 'name']);
            },
        ])->all([
            'id',
            'slug',
            'user_id',
            'published_at',
            'name',
            'summary'
        ]);

        return $model;
    }

    /**
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function latestPageMain(int $limit = 5):\Illuminate\Support\Collection
    {
        $this->resetCriteria();
        $this->pushCriteria(new CriteriaPostPublished);
        $this->pushCriteria($this->app->makeWith(CriteriaLimitPerPage::class, ['take' => $limit]));

        return $this->orderBy('published_at', 'desc')->all(['id', 'slug', 'published_at', 'name']);
    }
}
