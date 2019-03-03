<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Departments\StoreDepartmentRequest;
use App\Http\Requests\Departments\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\Request;
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
     * DepartmentController constructor.
     * @param ViewFactory $view
     * @param Redirector  $redirect
     */
    public function __construct(ViewFactory $view, Redirector $redirect, ResponseFactory $response)
    {
        $this->view = $view;
        $this->response = $response;
        $this->redirect = $redirect;
    }

    /**
     * Display a listing of the resource.
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $departments = Department::orderBy('name', 'asc')->paginate(25);
        return DepartmentResource::collection($departments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
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
     * Display the specified resource.
     *
     * @param  \App\Models\Department $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
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
