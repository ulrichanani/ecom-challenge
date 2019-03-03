<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Attributes\StoreAttributeValueRequest;
use App\Http\Requests\Admin\Attributes\UpdateAttributeValueRequest;
use App\Http\Resources\AttributeValueResource;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Contracts\View\Factory as ViewFactory;

class AttributeValuesController extends Controller
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
     * Display the attribute values page.
     *
     * @param Attribute $attribute
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Attribute $attribute)
    {
        return $this->view->make('admin.attributes-values.index', ['attribute_id' => $attribute->id]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Attribute $attribute
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list(Attribute $attribute)
    {
        $values = $attribute->values()->orderBy('value', 'asc')->paginate(25);
        return AttributeValueResource::collection($values);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAttributeValueRequest $request
     * @param Attribute                  $attribute
     * @return AttributeValueResource
     */
    public function store(StoreAttributeValueRequest $request, Attribute $attribute)
    {
        $value = AttributeValue::create([
            'attribute_id' => $attribute->id,
            'value' => $request->input('value')
        ]);

        return new AttributeValueResource($value);
    }

    /**
     * Display the specified resource.
     *
     * @param Attribute      $attribute
     * @param AttributeValue $value
     * @return AttributeValueResource
     */
    public function show(Attribute $attribute, AttributeValue $value)
    {
        return new AttributeValueResource($value);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAttributeValueRequest $request
     * @param  \App\Models\Attribute      $attribute
     * @param AttributeValue              $value
     * @return AttributeValueResource
     */
    public function update(UpdateAttributeValueRequest $request, Attribute $attribute, AttributeValue $value)
    {
        $value->update([
            'value' => $request->input('value')
        ]);

        return new AttributeValueResource($value);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Attribute      $attribute
     * @param AttributeValue $value
     * @return AttributeValueResource
     * @throws \Exception
     */
    public function destroy(Attribute $attribute, AttributeValue $value)
    {
        $value->delete();
        return new AttributeValueResource($value);
    }
}
