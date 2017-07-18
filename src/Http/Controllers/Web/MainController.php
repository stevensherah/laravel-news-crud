<?php

namespace Sevenpluss\NewsCrud\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Sevenpluss\NewsCrud\Http\Controllers\Traits\CommonMethodsForControllers;
use Sevenpluss\NewsCrud\Repositories\Contracts\PostRepositoryInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\CommentRepositoryInterface;

/**
 * Class MainController
 * @package Sevenpluss\NewsCrud\Http\Controllers\Web
 */
class MainController extends Controller
{
    use CommonMethodsForControllers;

    /**
     * MainController constructor.
     */
    public function __construct()
    {
        $this->setPageName('main');
        $this->prepareHeaderData();
        $this->prepareMetaData();
        $this->prepareTagsData();
    }

    /**
     * Display page home
     *
     * @param PostRepositoryInterface $postRepository
     * @param CommentRepositoryInterface $commentRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(PostRepositoryInterface $postRepository, CommentRepositoryInterface $commentRepository)
    {
        // posts popular list
        $posts_popular = $postRepository->popularPageMain(6);

        // posts latest list
        $posts_latest = $postRepository->latestPageMain(22);

        // comments latest list
        $comments_latest = $commentRepository->latestPageMain(20);

        return view('news::home.index', compact('posts_popular', 'posts_latest', 'comments_latest'));
    }
}
