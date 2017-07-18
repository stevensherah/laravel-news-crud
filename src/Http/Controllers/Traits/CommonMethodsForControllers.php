<?php

namespace Sevenpluss\NewsCrud\Http\Controllers\Traits;

use Illuminate\Contracts\View\View;
use Sevenpluss\NewsCrud\Prototypes\Image;
use Sevenpluss\NewsCrud\Repositories\Contracts\TagRepositoryInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\CategoryRepositoryInterface;

/**
 * Class CommonMethods
 * @package Sevenpluss\NewsCrud\Http\Controllers\Traits
 */
trait CommonMethodsForControllers
{
    /**
     * @var string
     */
    protected $page_name;

    /**
     * @var string|null
     */
    protected $category_name;

    /**
     * @return array
     */
    protected function getMetaDefault(): array
    {
        $meta = [
            'og_prefix' => 'og: http://ogp.me/ns#',
            'title' => null,
            'description' => null,
            'keywords' => null,
            'url_current' => url()->current(),
            'news' => null,
        ];

        $meta['images'][] = (array)$this->getMetaImageDefault();

        return array_merge($meta, trans('news::meta'));
    }

    /**
     * @return \Sevenpluss\NewsCrud\Prototypes\Image
     */
    protected function getMetaImageDefault()
    {
        $img = app()->makeWith(Image::class, [
            'slug' => 'meta-news-crud-logo.png',
            'url' => asset('vendor/news-crud/img/meta-news-crud-logo.png'),
        ]);

        $img->width = 192;
        $img->height = 192;
        $img->mime = 'png';
        $img->mimetypes = 'image/png';

        return $img;
    }

    /**
     * @param string $page
     * @return void
     */
    protected function setPageName(string $page): void
    {
        $this->page_name = $page;
    }

    /**
     * @return string
     */
    protected function getPageName(): string
    {
        return $this->page_name;
    }

    /**
     * @param string|null $category
     * @return void
     */
    protected function setCurrentCategoryName(?string $category): void
    {
        $this->category_name = $category;
    }

    /**
     * @return null|string
     */
    protected function getCurrentCategoryName():?string
    {
        return $this->category_name;
    }

    /**
     * @return void
     */
    protected function prepareHeaderData(): void
    {
        view()->composer('news::common.header', function (View $view) {

            $categories = app()->make(CategoryRepositoryInterface::class)->active(['id', 'slug', 'name']);

            $user = auth()->user();
            $current_category = $this->getCurrentCategoryName();

            $current_page = $this->getPageName();

            return $view->with(compact('current_category', 'categories', 'current_page', 'user'));
        });
    }

    /**
     * @param array $meta
     * @return void
     */
    protected function prepareMetaData(array $meta = []): void
    {
        view()->composer('news::common.meta', function (View $view) use ($meta) {

            $meta = !empty($meta) ? array_merge($this->getMetaDefault(), $meta) : $this->getMetaDefault();

            return $view->with(compact('meta'));
        });
    }

    /**
     * @param \Illuminate\Support\Collection|array $breadcrumbs
     * @return void
     */
    protected function prepareBreadcrumbData($breadcrumbs): void
    {
        view()->composer('news::common.breadcrumb', function (View $view) use ($breadcrumbs) {
            return $view->with(compact('breadcrumbs'));
        });
    }

    /**
     * @param null|string $active
     * @return void
     */
    protected function prepareTagsData(?string $active = null): void
    {
        view()->composer('news::common.tags_list', function (View $view) use ($active) {

            $tags = app()->make(TagRepositoryInterface::class)->activeHasPosts();

            return $view->with(compact('tags', 'active'));
        });
    }

    /**
     * @return string
     */
    protected function getLocaleLocationValue(): string
    {
        return config('news-crud.supported_locales')[app()->getLocale()]['regional'];
    }
}
