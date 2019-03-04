<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\StoreCategoryRequest;
use App\Http\Requests\Admin\Categories\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Department;
use Illuminate\Contracts\View\Factory as ViewFactory;

class CategoriesController extends Controller
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
        $category->delete();
        return new CategoryResource($category);
    }

    public function all() {
        return CategoryResource::collection(Category::all());
    }
}
