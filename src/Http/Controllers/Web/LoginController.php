<?php

namespace Sevenpluss\NewsCrud\Http\Controllers\Web;

use App\Http\Controllers\Auth\LoginController as AppLoginController;
use Sevenpluss\NewsCrud\Http\Controllers\Traits\CommonMethodsForControllers;
use Sevenpluss\NewsCrud\Prototypes\BreadcrumbElement;

/**
 * Class LoginController
 * @package Sevenpluss\NewsCrud\Http\Controllers\Web
 */
class LoginController extends AppLoginController
{
    use CommonMethodsForControllers;

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setPageName('login');
        $this->prepareHeaderData();
        $this->prepareMetaData(['title' => trans('news::users.login.meta.title')]);

        $breadcrumb = collect();
        $breadcrumb->push(new BreadcrumbElement(
            trans('news::users.login.breadcrumb')
        ));
        $this->prepareBreadcrumbData($breadcrumb);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        $locale = $this->getLocaleLocationValue();

        return view('news::auth.login', compact('locale'));
    }
}
