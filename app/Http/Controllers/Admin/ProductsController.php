<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\StoreProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ProductsController extends Controller
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
     * Display the resource main page.
     *
     * @param Category $category
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Category $category)
    {
        return $this->view->make('admin.products.index', ['category_id' => $category->id]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list(Category $category)
    {
        $products = $category->products()
            ->orderBy('name', 'asc')
            ->paginate(25);
        return new ProductCollection($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->view->make('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @param Category            $category
     * @return ProductResource
     */
    public function store(StoreProductRequest $request, Category $category)
    {
        dd($request->all());
        $product = Product::create([
            'category_id' => $category->id,
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param Category             $category
     * @param  \App\Models\Product $product
     * @return ProductResource
     */
    public function show(Category $category, Product $product)
    {
//        dd($product->categories, $product->attributes);
//        dd($product->with(['attributes', 'categories'])->get());
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return $this->view->make('admin.products.edit',  ['product_id' => $product->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequest $request
     * @param Category             $category
     * @param  \App\Models\Product $product
     * @return ProductResource
     */
    public function update(UpdateProductRequest $request, Category $category, Product $product)
    {
        $product->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category             $category
     * @param  \App\Models\Product $product
     * @return ProductResource
     * @throws \Exception
     */
    public function destroy(Category $category, Product $product)
    {
        $product->delete();
        return new ProductResource($product);
    }
}
