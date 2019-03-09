<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Department;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Support\Facades\Session;

class CategoriesController extends Controller
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
     * @param Category $category
     * @param Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Category $category, Request $request)
    {
        $currentCategory = $category;
        $currentDepartment = $category->department;

        $products = $currentCategory->products()->orderBy('name')->paginate(15);
        $featured_products = Product::featured()->inRandomOrder()->take(2)->get();

        $categories = $currentDepartment->categories;
        $attributes = Attribute::with('values')->get();

        return $this->view->make('products.listing', [
            'currentDepartment' => $currentDepartment,
            'currentCategory' => $currentCategory,
            'products' => $products,
            'categories' => $categories,
            'featured_products' => $featured_products,
            'attributes' => $attributes
        ]);
    }
}
