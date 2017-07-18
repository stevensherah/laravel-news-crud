<?php

namespace Sevenpluss\NewsCrud\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Relations\Relation;
use Sevenpluss\NewsCrud\Http\Requests\Web\TagsShowRequest;
use Sevenpluss\NewsCrud\Http\Controllers\Traits\CommonMethodsForControllers;
use Sevenpluss\NewsCrud\Prototypes\BreadcrumbElement;
use Sevenpluss\NewsCrud\Repositories\Contracts\TagRepositoryInterface;

/**
 * Class TagController
 * @package Sevenpluss\NewsCrud\Http\Controllers\Web
 */
class TagController extends Controller
{
    use CommonMethodsForControllers;

    /**
     * @param TagRepositoryInterface $repository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(TagRepositoryInterface $repository)
    {
        $this->setPageName('tags');

        $breadcrumb = collect();
        $breadcrumb->push(new BreadcrumbElement(trans('news::tags.index.breadcrumb')));
        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareMetaData(trans('news::tags.index.meta'));
        $this->prepareHeaderData();

        $tags = $repository->activeHasPosts();

        return view('news::tags.index', compact('tags'));
    }

    /**
     * @param TagsShowRequest $request
     * @param TagRepositoryInterface $repository
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(TagsShowRequest $request, TagRepositoryInterface $repository, string $slug)
    {
        $tag = $repository->find($slug, ['slug', 'name', 'active']);

        if ($tag->active == false) {
            abort(403);
        }

        $this->setPageName('news');

        $auth = auth();

        $breadcrumb = collect();
        $breadcrumb->push(new BreadcrumbElement(
            trans('news::post.index.breadcrumb'),
            route('news.index', [], false)
        ));

        $breadcrumb->push(new BreadcrumbElement(trans('news::tags.show.breadcrumb', ['tag' => $tag->name])));

        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareMetaData([
            'title' => trans('news::tags.show.meta.title', ['tag' => $tag->name])
        ]);
        $this->prepareHeaderData();
        $this->prepareTagsData($tag->slug);


        $posts = $tag->posts()->with([
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
            ->published()
            ->orderBy('published_at', 'desc')->paginate(15, [
                'id',
                'slug',
                'user_id',
                'published_at',
                'category_id',
                'name',
                'summary',
            ]);

        return view('news::tags.show', compact('posts', 'tag', 'auth'));
    }
}
