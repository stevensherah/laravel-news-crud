<?php

namespace Sevenpluss\NewsCrud\Http\Controllers\Api\v1;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Response;
use Sevenpluss\NewsCrud\Http\Requests\Api\CommentCreateRequest;
use Sevenpluss\NewsCrud\Http\Requests\Api\CommentsLatestRequest;
use Sevenpluss\NewsCrud\Repositories\Contracts\CommentRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Sevenpluss\NewsCrud\Exceptions\NoContentException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class CommentController
 * @package Sevenpluss\NewsCrud\Http\Controllers\Api\v1
 */
class CommentController extends RootApiController
{
    /**
     * @param CommentCreateRequest $request
     * @param Guard $auth
     * @return \Illuminate\Http\JsonResponse
     * @throws BadRequestHttpException
     * @throws HttpException
     */
    public function store(CommentCreateRequest $request, Guard $auth)
    {
        $this->setApiLocale($request);

        $response = ['status' => 'error'];

        try {
            $statusCode = 200;

            switch (true) {
                case !$auth->check() && $request->has('user_id'):
                case $auth->check() && ($request->has('name') || $request->has('email')
                        || ($request->has('user_id') && $auth->user()->id != $request->has('user_id'))):

                    abort(403);
                    break;
            }

            $comment = app()->make(CommentRepositoryInterface::class)->newInstance();

            $is_ok = false;

            if ($auth->check() && $request->has('user_id') && $request->input('user_id') == $auth->user()->id) {
                $comment->user_id = $auth->user()->id;
                $is_ok = true;
            } elseif (!$auth->check() && $request->has('name') && $request->has('email')) {
                $comment->name = $request->input('name');
                $comment->email = $request->input('email');
                $is_ok = true;
            }

            if ($is_ok == true) {

                $comment->post_id = $request->input('post_id');

                $comment->content = $request->input('content');

                if ($comment->save()) {
                    $response['comment'] = $comment;
                    $response['status'] = 'OK';
                }

            } else {
                abort(400);
            }

        } catch (BadRequestHttpException | HttpException $e) {

            $response['error'] = [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ];

            $statusCode = $e->getCode();

        } finally {
            return Response::json($response, $statusCode);
        }
    }

    /**
     * @param CommentsLatestRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws BadRequestHttpException
     * @throws NoContentException
     * @throws HttpException
     */
    public function latest(CommentsLatestRequest $request)
    {
        $this->setApiLocale($request);

        $response = ['status' => 'error'];

        try {
            $statusCode = 200;

            $result = app()->make(CommentRepositoryInterface::class)->latestPageMain($request->input('limit', 10));

            if ($result->isNotEmpty()) {
                $response['results'] = $result->toArray();
            } else {
                throw new NoContentException(trans('news::common.messages.no_content'));
            }

            $response['status'] = 'OK';

        } catch (BadRequestHttpException | HttpException $e) {

            $response['error'] = [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ];

            $statusCode = $e->getCode();

        } catch (NoContentException $e) {

            $response['message'] = $e->getMessage();
            $statusCode = $e->getCode();

        } finally {
            return Response::json($response, $statusCode);
        }
    }
}
