<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Departments\StoreDepartmentRequest;
use App\Http\Requests\Admin\Departments\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Routing\Redirector;

class DepartmentsController extends Controller
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
     * Display the departments page.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->view->make('admin.departments.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list()
    {
        $departments = Department::orderBy('name', 'asc')->paginate(25);
        return DepartmentResource::collection($departments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDepartmentRequest $request
     * @return DepartmentResource
     */
    public function store(StoreDepartmentRequest $request)
    {
        $department = Department::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return new DepartmentResource($department);
    }

    /**
     * Show a resource.
     *
     * @param Department $department
     * @return DepartmentResource
     */
    public function show(Department $department)
    {
        return new DepartmentResource($department);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDepartmentRequest $request
     * @param  \App\Models\Department $department
     * @return DepartmentResource
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return new DepartmentResource($department);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department $department
     * @return DepartmentResource
     * @throws \Exception
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return new DepartmentResource($department);
    }
}
