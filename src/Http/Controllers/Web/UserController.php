<?php

namespace Sevenpluss\NewsCrud\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Sevenpluss\NewsCrud\Http\Controllers\Traits\CommonMethodsForControllers;
use Sevenpluss\NewsCrud\Prototypes\BreadcrumbElement;
use Sevenpluss\NewsCrud\Repositories\Contracts\UserRepositoryInterface;

/**
 * Class UserController
 * @package Sevenpluss\NewsCrud\Http\Controllers\Web
 */
class UserController extends Controller
{
    use CommonMethodsForControllers;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->setPageName('user');
        $this->prepareHeaderData();
        $this->prepareTagsData();
    }

    public function index(UserRepositoryInterface $repository)
    {
        $breadcrumb = collect();
        $breadcrumb->push(new BreadcrumbElement(trans('news::users.index.breadcrumb')));
        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareMetaData(trans('news::users.index.meta'));

        $users = $repository->paginate(15, ['id', 'name']);

        return view('news::user.index', compact('users'));
    }

    /**
     * @param UserRepositoryInterface $repository
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(UserRepositoryInterface $repository, int $id)
    {
        $user = $repository->show($id);

        $breadcrumb = collect();
        $breadcrumb->push(new BreadcrumbElement(
            trans('news::users.index.breadcrumb'),
            route('user.index', [], false)
            ));
        $breadcrumb->push(new BreadcrumbElement(trans('news::users.show.breadcrumb', ['name' => $user->name])));
        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareMetaData(['title' => trans('news::users.show.meta.title', ['name' => $user->name])]);

        return view('news::user.show', compact('user'));
    }
}
