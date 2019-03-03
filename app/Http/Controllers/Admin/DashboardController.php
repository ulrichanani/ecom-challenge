<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory as ViewFactory;

class DashboardController extends Controller
{

    /**
     * @var ViewFactory
     */
    private $view;

    /**
     * Constructor.
     * @param ViewFactory $view
     */
    public function __construct(ViewFactory $view)
    {
        $this->view = $view;
    }

    public function index() {
        return $this->view->make('admin.dashboard');
    }
}
