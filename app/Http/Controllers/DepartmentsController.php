<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Department;
use App\Models\Product;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Session;

class DepartmentsController extends Controller
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

    /**
     * Display the department products.
     *
     * @param Department $department
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Department $department)
    {
        $currentDepartment = $department;
        $currentCategory = $currentDepartment->categories->first();

        $products = $currentDepartment->products()->orderBy('name')->paginate(15);
        $featured_products = Product::featured()->inRandomOrder()->take(2)->get();

        $categories = $currentDepartment->categories;
        $attributes = Attribute::with('values')->get();

        return $this->view->make('products.listing', [
            'currentDepartment' => $currentDepartment,
            'products' => $products,
            'categories' => $categories,
            'featured_products' => $featured_products,
            'attributes' => $attributes
        ]);
    }
}
