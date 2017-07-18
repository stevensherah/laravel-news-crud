<?php

namespace Sevenpluss\NewsCrud\Http\Controllers\Web;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sevenpluss\NewsCrud\Http\Requests\Web\PostIndexRequest;
use Sevenpluss\NewsCrud\Http\Requests\Web\PostShowRequest;
use Sevenpluss\NewsCrud\Http\Requests\Web\PostCreateRequest;
use Sevenpluss\NewsCrud\Http\Requests\Web\PostEditRequest;
use Sevenpluss\NewsCrud\Http\Controllers\Traits\CommonMethodsForControllers;
use Sevenpluss\NewsCrud\Prototypes\BreadcrumbElement;
use Sevenpluss\NewsCrud\Prototypes\Message;
use Sevenpluss\NewsCrud\Repositories\Contracts\PostRepositoryInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\CategoryRepositoryInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\TagRepositoryInterface;

/**
 * Class PostController
 * @package Sevenpluss\NewsCrud\Http\Controllers\Web
 */
class PostController extends Controller
{
    use CommonMethodsForControllers;

    /**
     * @param PostIndexRequest $request
     * @param PostRepositoryInterface $postRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(PostIndexRequest $request, PostRepositoryInterface $postRepository)
    {
        $this->setPageName('news');

        $breadcrumb = collect();
        $breadcrumb->push(new BreadcrumbElement(trans('news::post.index.breadcrumb')));
        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareHeaderData();
        $this->prepareMetaData(trans('news::post.index.meta'));
        $this->prepareTagsData();

        $posts = $postRepository->paginateRequest($request);

        $auth = auth();

        return view('news::post.index', compact('posts', 'auth'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @param CategoryRepositoryInterface $categoryRepository
     * @param TagRepositoryInterface $tagRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create(
        Request $request,
        CategoryRepositoryInterface $categoryRepository,
        TagRepositoryInterface $tagRepository
    ) {
        $this->middleware('auth');

        if (!auth()->check()) {

            $messages = collect();
            $messages->push(new Message(trans('news::post.create.messages.access_denied'), 'danger'));
            $request->session()->flash('messages', $messages);

            return redirect()->route('news.index');
        }

        $this->setPageName('news');

        $breadcrumb = collect();

        $breadcrumb->push(new BreadcrumbElement(
            trans('news::post.index.breadcrumb'),
            route('news.index', [], false)
        ));

        $breadcrumb->push(new BreadcrumbElement(trans('news::post.create.breadcrumb')));

        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareHeaderData();
        $this->prepareMetaData(trans('news::post.create.meta'));

        // form elements
        $categories = $categoryRepository->all(['id', 'name']);
        $tags = $tagRepository->all(['slug', 'name']);

        $user_id = auth()->user()->id;

        $locale = $this->getLocaleLocationValue();

        return view('news::post.create', compact('user_id', 'locale', 'categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostCreateRequest $request
     * @param PostRepositoryInterface $postRepository
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostCreateRequest $request, PostRepositoryInterface $postRepository)
    {
        $this->middleware('auth');


        $post = $postRepository->newInstance();

        if ($request->has('published_now')) {

            $post->published_at = Carbon::now();

        } else {
            $post->published_at = $request->input('published_at');
        }

        $post->category_id = $request->input('category_id');
        $post->user_id = auth()->user()->id;

        $post->slug = $request->input('slug');


        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->keywords = $request->input('keywords');

        $post->name = $request->input('name');
        $post->summary = $request->input('summary');
        $post->story = $request->input('story');


        if ($post->save()) {
            $messages = collect();
            $messages->push(new Message(trans('news::post.store.messages.success'), 'success'));
            $request->session()->flash('messages', $messages);
        }


        if ($request->has('tags') && is_array($request->input('tags'))) {
            $post->tags()->sync($request->input('tags'));
        }

        return redirect()->route('news.index');
    }

    /**
     * @param PostShowRequest $request
     * @param PostRepositoryInterface $postRepository
     * @param int $id
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(
        PostShowRequest $request,
        PostRepositoryInterface $postRepository,
        int $id,
        string $slug
    ) {
        $post = $postRepository->show($id);


        if (is_null($post->published_at) || ($post->published_at instanceof Carbon && Carbon::now() < $post->published_at)) {
            abort(403);
        } elseif ($post->slug != $slug) {
            return redirect()->route('news.show', ['id' => $post->id, 'slug' => $post->slug]);
        }

        $this->setPageName('categories');
        $this->setCurrentCategoryName($post->category->slug);

        $postRepository->viewsIncrement($id);

        $post->views += 1;

        $breadcrumb = collect();

        $breadcrumb->push(new BreadcrumbElement(
            trans('news::post.index.breadcrumb'),
            route('news.index', [], false)
        ));

        $breadcrumb->push(new BreadcrumbElement(
            $post->category->name,
            $post->category->url
        ));

        $breadcrumb->push(new BreadcrumbElement($post->name));

        $this->prepareBreadcrumbData($breadcrumb);


        $meta = [
            'title' => $post->getTitle(),
            'description' => $post->getDescription(),
        ];

        if (!is_null($post->keywords)) {
            $meta['keywords'] = $post->keywords;
        }

        $this->prepareMetaData($meta);
        $this->prepareHeaderData();
        $this->prepareTagsData();


        view()->composer('news::post.comment_add', function (View $view) use ($id) {

            $locale = config('news-crud.supported_locales')[app()->getLocale()]['regional'];

            $post_id = $id;

            $auth = auth();

            return $view->with(compact('locale', 'post_id', 'auth'));
        });

        $comments = $post->comments()->with([
            'user' => function (Relation $query) {
                $query->select(['id', 'name']);
            }
        ])->orderBy('created_at', 'desc')->paginate(10, [
            'id',
            'user_id',
            'name',
            'created_at',
            'content'
        ], 'commentPage');

        return view('news::post.show', compact('post', 'comments'));
    }

    /**
     * @param Request $request
     * @param PostRepositoryInterface $postRepository
     * @param int $id
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(
        Request $request,
        PostRepositoryInterface $postRepository,
        CategoryRepositoryInterface $categoryRepository,
        TagRepositoryInterface $tagRepository,
        int $id,
        string $slug
    ) {
        $this->middleware('auth');

        if (!auth()->check()) {

            $messages = collect();
            $messages->push(new Message(trans('news::post.edit.messages.access_denied'), 'danger'));
            $request->session()->flash('messages', $messages);

            return redirect()->route('news.index');
        }

        $this->setPageName('news');

        $post = $postRepository->findOrFail($id);


        if ($post->slug != $slug) {
            return redirect()->route('news.show', ['id' => $post->id, 'slug' => $post->slug]);
        }


        $breadcrumb = collect();

        $breadcrumb->push(new BreadcrumbElement(
            trans('news::post.index.breadcrumb'),
            route('news.index', [], false)
        ));

        $breadcrumb->push(new BreadcrumbElement(
            $post->name,
            $post->url
        ));

        $breadcrumb->push(new BreadcrumbElement(
            trans('news::post.edit.breadcrumb')
        ));

        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareMetaData(trans('news::post.edit.meta'));
        $this->prepareHeaderData();

        // form elements
        $categories = $categoryRepository->all(['id', 'name']);
        $tags = $tagRepository->all(['slug', 'name']);

        $locale = $this->getLocaleLocationValue();

        $user_id = auth()->user()->id;

        return view('news::post.edit', compact('post', 'categories', 'tags', 'locale', 'user_id'));
    }

    /**
     * @param PostEditRequest $request
     * @param PostRepositoryInterface $repository
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostEditRequest $request, PostRepositoryInterface $repository, int $id)
    {
        $this->middleware('auth');

        if ($id == $request->input('id')) {

            $post = $repository->findOrFail($id);

            if ($request->has('published_now')) {
                $post->published_at = Carbon::now();
            } else {
                $post->published_at = $request->input('published_at');
            }

            $post->category_id = $request->input('category_id');

            $post->slug = $request->input('slug');


            if ($request->has('tags') && is_array($request->input('tags'))) {
                $post->tags()->sync($request->input('tags'));
            } else {
                $post->tags()->sync([]);
            }


            $post->title = $request->input('title');
            $post->description = $request->input('description');
            $post->keywords = $request->input('keywords');

            $post->name = $request->input('name');
            $post->summary = $request->input('summary');
            $post->story = $request->input('story');

            if ($post->save()) {
                $messages = collect();
                $messages->push(new Message(trans('news::post.update.messages.success'), 'success'));
                $request->session()->flash('messages', $messages);
            }
        }

        return redirect()->route('news.index');
    }
}
