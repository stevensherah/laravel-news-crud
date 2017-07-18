<?php

namespace Sevenpluss\NewsCrud\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class RootApiController
 * @package Sevenpluss\NewsCrud\Http\Controllers\Api\v1
 */
class RootApiController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function setApiLocale(Request $request):void
    {
        if ($request->hasHeader('locale') && in_array($request->header('locale'), config('news-crud.locales'))) {
            app()->setLocale($request->header('locale'));
        }
    }
}
