<?php

namespace Sevenpluss\NewsCrud\Http\Controllers\Web;

use App\Http\Controllers\Auth\RegisterController as AppRegisterController;
use Sevenpluss\NewsCrud\Http\Controllers\Traits\CommonMethodsForControllers;
use Sevenpluss\NewsCrud\Prototypes\BreadcrumbElement;

/**
 * Class RegisterController
 * @package Sevenpluss\NewsCrud\Http\Controllers\Web
 */
class RegisterController extends AppRegisterController
{
    use CommonMethodsForControllers;

    /**
     * RegisterController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setPageName('register');
        $this->prepareHeaderData();
        $this->prepareMetaData(['title' => trans('news::users.register.meta.title')]);

        $breadcrumb = collect();
        $breadcrumb->push(new BreadcrumbElement(
            trans('news::users.register.breadcrumb')
        ));
        $this->prepareBreadcrumbData($breadcrumb);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $locale = $this->getLocaleLocationValue();

        return view('news::auth.register', compact('locale'));
    }
}
