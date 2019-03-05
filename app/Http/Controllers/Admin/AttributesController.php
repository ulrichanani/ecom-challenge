<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Attributes\StoreAttributeRequest;
use App\Http\Requests\Admin\Attributes\UpdateAttributeRequest;
use App\Http\Resources\AttributeResource;
use App\Models\Attribute;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;

class AttributesController extends Controller
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
     * Display the atttributes page.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->view->make('admin.attributes.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list()
    {
        $attributes = Attribute::orderBy('name', 'asc')->paginate(25);
        return AttributeResource::collection($attributes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAttributeRequest $request
     * @return AttributeResource
     */
    public function store(StoreAttributeRequest $request)
    {
        $attribute = Attribute::create([
            'name' => $request->input('name')
        ]);

        return new AttributeResource($attribute);
    }

    /**
     * Show a resource.
     *
     * @param Attribute $attribute
     * @return AttributeResource
     */
    public function show(Attribute $attribute)
    {
        return new AttributeResource($attribute);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAttributeRequest $request
     * @param  \App\Models\Attribute $attribute
     * @return AttributeResource
     */
    public function update(UpdateAttributeRequest $request, Attribute $attribute)
    {
        $attribute->update([
            'name' => $request->input('name')
        ]);

        return new AttributeResource($attribute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attribute $attribute
     * @return AttributeResource
     * @throws \Exception
     */
    public function destroy(Attribute $attribute)
    {
        if ($attribute->delete())
            return new AttributeResource($attribute);
        else
            return $this->response->json([
                'message' => "You can't delete this resource!"
            ], 400);
    }
}
