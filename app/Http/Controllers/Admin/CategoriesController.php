<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\StoreCategoryRequest;
use App\Http\Requests\Admin\Categories\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductCollection;
use App\Models\Category;
use App\Models\Department;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Routing\ResponseFactory;

class CategoriesController extends Controller
{

    /**
     * @var ViewFactory
     */
    private $view;
    /**
     * @var ResponseFactory
     */
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
     * Display the categories page.
     *
     * @param Department $department
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Department $department)
    {
        return $this->view->make('admin.categories.index', ['department_id' => $department->id]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Department $department
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list(Department $department)
    {
        $categories = $department->categories()->orderBy('name', 'asc')->paginate(25);
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @param Department           $department
     * @return CategoryResource
     */
    public function store(StoreCategoryRequest $request, Department $department)
    {
        $category = Category::create([
            'department_id' => $department->id,
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category $category
     * @return CategoryResource
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param  \App\Models\Category $category
     * @return CategoryResource
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category $category
     * @return CategoryResource
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        if ($category->delete())
            return new CategoryResource($category);
        else
            return $this->response->json([
                'message' => "You can't delete this resource!"
            ], 400);
    }

    public function all()
    {
        return CategoryResource::collection(Category::all());
    }

    public function products(Category $category)
    {
        return $this->view->make('admin.categories.products', ['category_id' => $category->category_id]);
    }

    public function productsList(Category $category)
    {
        $products = $category->products()
            ->orderBy('name', 'asc')
            ->paginate(25);
        return new ProductCollection($products);
    }
}
