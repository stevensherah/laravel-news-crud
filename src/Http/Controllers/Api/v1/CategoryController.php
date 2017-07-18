<?php

namespace Sevenpluss\NewsCrud\Http\Controllers\Api\v1;

use Sevenpluss\NewsCrud\Http\Requests\Api\CategoryDeleteRequest;
use Sevenpluss\NewsCrud\Repositories\Contracts\CategoryRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class CategoryController
 * @package Sevenpluss\NewsCrud\Http\Controllers\Api\v1
 */
class CategoryController extends RootApiController
{
    /**
     * @param CategoryDeleteRequest $request
     * @param CategoryRepositoryInterface $repository
     * @return \Illuminate\Http\JsonResponse
     * @throws BadRequestHttpException
     * @throws HttpException
     */
    public function destroy(CategoryDeleteRequest $request, CategoryRepositoryInterface $repository)
    {
        $response = ['status' => 'error'];

        try {
            $statusCode = 200;

            if ($repository->delete($request->input('id'))) {
                $response['status'] = 'OK';
            }

        } catch (BadRequestHttpException | HttpException $e) {

            $response['error'] = [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ];

            $statusCode = $e->getCode();

        } finally {
            return response()->json($response, $statusCode);
        }
    }
}
