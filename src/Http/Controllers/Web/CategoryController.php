<?php

namespace Sevenpluss\NewsCrud\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Relations\Relation;
use Sevenpluss\NewsCrud\Http\Requests\Web\PostIndexRequest;
use Sevenpluss\NewsCrud\Http\Requests\Web\CategoryCreateRequest;
use Sevenpluss\NewsCrud\Http\Requests\Web\CategoryEditRequest;
use Sevenpluss\NewsCrud\Http\Controllers\Traits\CommonMethodsForControllers;
use Sevenpluss\NewsCrud\Prototypes\BreadcrumbElement;
use Sevenpluss\NewsCrud\Prototypes\Message;
use Sevenpluss\NewsCrud\Repositories\Contracts\CategoryRepositoryInterface;

/**
 * Class CategoryController
 * @package Sevenpluss\NewsCrud\Http\Controllers\Web
 */
class CategoryController extends Controller
{
    use CommonMethodsForControllers;

    /**
     * Display a listing of the resource.
     *
     * @param CategoryRepositoryInterface $categoryRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(CategoryRepositoryInterface $categoryRepository)
    {
        $this->setPageName('category_crud');

        $breadcrumb = collect();
        $breadcrumb->push(new BreadcrumbElement(trans('news::category.index.breadcrumb')));
        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareMetaData(trans('news::category.index.meta'));
        $this->prepareHeaderData();

        $categories = $categoryRepository->orderBy('updated_at', 'desc')->paginate(10,
            ['id', 'slug', 'name', 'active']);

        return view('news::category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageName('category_crud');

        $this->prepareMetaData(trans('news::category.create.meta'));
        $this->prepareHeaderData();


        $breadcrumb = collect();

        $breadcrumb->push(new BreadcrumbElement(
            trans('news::category.index.breadcrumb'),
            route('category.index', [], false)
        ));

        $breadcrumb->push(new BreadcrumbElement(trans('news::category.create.breadcrumb')));

        $this->prepareBreadcrumbData($breadcrumb);

        $locale = $this->getLocaleLocationValue();

        return view('news::category.create', compact('locale'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryCreateRequest $request
     * @param CategoryRepositoryInterface $repository
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryCreateRequest $request, CategoryRepositoryInterface $repository)
    {
        $attributes = $request->all();

        if (!$request->has('slug')) {
            $attributes['slug'] = str_slug($request->input('name'));
        }

        if ($repository->create($attributes)) {
            $messages = collect();
            $messages->push(new Message(trans('news::category.store.messages.success_created'), 'success'));
            $request->session()->flash('messages', $messages);
        }

        return redirect()->route('category.index');
    }

    /**
     * @param PostIndexRequest $request
     * @param CategoryRepositoryInterface $categoryRepository
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(PostIndexRequest $request, CategoryRepositoryInterface $categoryRepository, string $slug)
    {
        $category = $categoryRepository->findBy('slug', $slug, ['id', 'slug', 'name', 'active'])->first();

        if ($category->active == false) {
            abort(403);
        }

        $this->setPageName('categories');

        $this->setCurrentCategoryName($category->slug);

        $auth = auth();

        $breadcrumb = collect();

        $breadcrumb->push(new BreadcrumbElement(
            trans('news::post.index.breadcrumb'),
            route('news.index', [], false)
        ));

        $breadcrumb->push(new BreadcrumbElement($category->name));

        $this->prepareBreadcrumbData($breadcrumb);


        $this->prepareMetaData(['title' => trans('news::category.show.meta.title', ['category' => $category->name])]);
        $this->prepareHeaderData();
        $this->prepareTagsData();

        $posts = $category->posts()->with([
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

        return view('news::category.show', compact('category', 'posts', 'auth'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CategoryRepositoryInterface $categoryRepository
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(CategoryRepositoryInterface $categoryRepository, int $id)
    {
        $category = $categoryRepository->findOrFail($id);

        $this->setPageName('category_crud');

        $breadcrumb = collect();

        $breadcrumb->push(new BreadcrumbElement(
            trans('news::category.index.breadcrumb'),
            route('category.index', [], false)
        ));

        $breadcrumb->push(new BreadcrumbElement(trans('news::category.edit.breadcrumb')));

        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareMetaData(trans('news::category.edit.meta'));

        $locale = $this->getLocaleLocationValue();

        return view('news::category.edit', compact('category', 'locale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryEditRequest $request
     * @param CategoryRepositoryInterface $repository
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryEditRequest $request, CategoryRepositoryInterface $repository, int $id)
    {
        $attributes = $request->all();

        if (!$request->has('active')) {
            $attributes['active'] = null;
        }

        if ($repository->findOrFail($id)->update($attributes)) {
            $messages = collect();
            $messages->push(new Message(trans('news::category.update.messages.success_updated'), 'success'));
            $request->session()->flash('messages', $messages);
        }

        return redirect()->route('category.index');
    }
}
