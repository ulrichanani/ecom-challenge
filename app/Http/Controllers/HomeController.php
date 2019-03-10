<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\ResponseFactory;

class HomeController extends Controller
{
    private $view;
    private $response;
    /**
     * @var Redirector
     */
    private $redirect;

    /**
     * Create a new controller instance.
     *
     * @param ViewFactory     $view
     * @param ResponseFactory $response
     * @param Redirector      $redirect
     */
    public function __construct(ViewFactory $view, ResponseFactory $response, Redirector $redirect)
    {
        $this->view = $view;
        $this->response = $response;
        $this->redirect = $redirect;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $url = \Session::get('PRODUCTS_PAGE');
        if (!empty($url))
            return $this->redirect->to($url);

        return $this->redirect->route('categories.show', Category::first()->id);
    }

    /**
     * Show the application products search page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search()
    {
        return $this->view->make('search');
    }
}
