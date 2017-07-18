<?php

namespace Sevenpluss\NewsCrud\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Sevenpluss\NewsCrud\Http\Controllers\Traits\CommonMethodsForControllers;
use Sevenpluss\NewsCrud\Http\Requests\Web\CommentsIndexRequest;
use Sevenpluss\NewsCrud\Models\User;
use Sevenpluss\NewsCrud\Prototypes\BreadcrumbElement;
use Sevenpluss\NewsCrud\Repositories\Contracts\CommentRepositoryInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\UserRepositoryInterface;

/**
 * Class CommentController
 * @package Sevenpluss\NewsCrud\Http\Controllers\Web
 */
class CommentController extends Controller
{
    use CommonMethodsForControllers;

    /**
     * CommentController constructor.
     */
    public function __construct()
    {
        $this->setPageName('comments');
    }

    /**
     * @param CommentsIndexRequest $request
     * @param CommentRepositoryInterface $commentRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(CommentsIndexRequest $request, CommentRepositoryInterface $commentRepository)
    {
        $comments = collect();

        $auth = auth();

        $category_name = trans('news::comments.index.name');

        $meta = trans('news::comments.index.meta');

        $breadcrumb = collect();

        $breadcrumb->push(new BreadcrumbElement(
            trans('news::post.index.breadcrumb'),
            route('news.index', [], false)
        ));


        if ($request->has('user_id')) {

            $user = app()->make(UserRepositoryInterface::class)->find($request->input('user_id'), ['id', 'name']);

            if ($user instanceof User) {

                $comments = $user->comments()->paginate()->appends('user_id', $request->input('user_id'));

                $category_name = trans('news::comments.index.name_user', ['name' => $user->name]);

                $breadcrumb->push(new BreadcrumbElement($user->name, $user->url));
            }

        } else {

            $comments = $commentRepository->paginateRequest($request);

            $breadcrumb->push(new BreadcrumbElement(
                trans('news::post.index.breadcrumb'),
                route('news.index', [], false)
            ));
        }

        $breadcrumb->push(new BreadcrumbElement(trans('news::comments.index.breadcrumb')));

        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareMetaData($meta);
        $this->prepareHeaderData();

        return view('news::comments.index', compact('auth', 'category_name', 'comments'));
    }
}
