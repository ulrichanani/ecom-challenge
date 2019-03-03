<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Routing\Redirector;

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
     * @var Redirector
     */
    private $redirect;

    /**
     * Constructor.
     * @param ViewFactory     $view
     * @param Redirector      $redirect
     * @param ResponseFactory $response
     */
    public function __construct(ViewFactory $view, Redirector $redirect, ResponseFactory $response)
    {
        $this->view = $view;
        $this->response = $response;
        $this->redirect = $redirect;
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
        dump($department, $department->categories);
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
     * @param Department            $department
     * @param  \App\Models\Category $category
     * @return CategoryResource
     */
    public function show(Department $department, Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Department                $department
     * @param  \App\Models\Category     $category
     * @return CategoryResource
     */
    public function update(Request $request, Department $department, Category $category)
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
     * @param Department            $department
     * @param  \App\Models\Category $category
     * @return CategoryResource
     * @throws \Exception
     */
    public function destroy(Department $department, Category $category)
    {
        $category->delete();
        return new CategoryResource($category);
    }
}
