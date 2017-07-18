<?php

namespace Sevenpluss\NewsCrud\Http\Controllers\Api\v1;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Response;
use Sevenpluss\NewsCrud\Decorators\PostJsonDecorator;
use Sevenpluss\NewsCrud\Http\Requests\Api\PostDeleteRequest;
use Sevenpluss\NewsCrud\Http\Requests\Web\PostIndexRequest;
use Sevenpluss\NewsCrud\Repositories\Contracts\PostRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Sevenpluss\NewsCrud\Exceptions\NoContentException;

/**
 * Class PostController
 * @package Sevenpluss\NewsCrud\Http\Controllers\Api\v1
 */
class PostController extends RootApiController
{
    /**
     * @param Container $app
     * @param PostIndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws BadRequestHttpException
     * @throws HttpException
     * @throws NoContentException
     */
    public function pagination(Container $app, PostIndexRequest $request)
    {
        $this->setApiLocale($request);

        $response = ['status' => 'error'];

        try {
            $statusCode = 200;

            $response['status'] = 'OK';
            $response['tag_active'] = $request->input('tag');
            $response['auth_check'] = $app['auth']->check();

            $response['posts'] = $app->make(PostJsonDecorator::class)->paginateRequest($request);

            if (empty($response['posts']['data'])) {
                throw new NoContentException(trans('news::common.messages.no_content'));
            }

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

    /**
     * @param PostDeleteRequest $request
     * @param PostRepositoryInterface $repository
     * @return \Illuminate\Http\JsonResponse
     * @throws BadRequestHttpException
     * @throws HttpException
     */
    public function destroy(PostDeleteRequest $request, PostRepositoryInterface $repository)
    {
        $response = ['status' => 'error'];

        try {
            $statusCode = 200;

            if ($request->has('id')) {

                if ($repository->delete($request->input('id'))) {
                    $response['status'] = 'OK';
                }
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
}
