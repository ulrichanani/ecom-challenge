<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;

class UserController extends Controller
{
    private $view;
    private $response;

    /**
     * Constructor.
     * @param ViewFactory     $view
     * @param ResponseFactory $response
     */
    public function __construct(ViewFactory $view, ResponseFactory $response)
    {
        $this->view = $view;
        $this->response = $response;
    }

    public function index()
    {

    }

    public function savedItems()
    {
        $savedItems = ShoppingCart::current()->saved()->get();
        return $this->view->make('users.saved-products', compact('savedItems'));
    }
}
