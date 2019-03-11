<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\StoreProductRequest;
use App\Http\Requests\Admin\Products\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Traits\UploadableTrait;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\ResponseFactory;

class ProductsController extends Controller
{
    use UploadableTrait;

    /**
     * @var ViewFactory
     */
    private $view;
    /**
     * @var Redirector
     */
    private $redirector;
    /**
     * @var ResponseFactory
     */
    private $response;

    /**
     * Constructor.
     * @param ViewFactory     $view
     * @param Redirector      $redirector
     * @param ResponseFactory $response
     */
    public function __construct(ViewFactory $view, Redirector $redirector, ResponseFactory $response)
    {
        $this->view = $view;
        $this->redirector = $redirector;
        $this->response = $response;
    }

    /**
     * Display the resource main page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return $this->view->make('admin.products.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return ProductCollection
     */
    public function list()
    {
        $products = Product::orderBy('name', 'asc')->paginate(25);
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
    public function store(StoreProductRequest $request)
    {
        $thumbnail = $this->storeFile($request->file('thumbnail'));
        $image1 = $this->storeFile($request->file('image'));
        $image2 = $request->file('image_2');
        $image2 = $image2 instanceof UploadedFile ? $this->storeFile($image2) : null;

        $product = Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description') ?? '',
            'price' => $request->input('price'),
            'discounted_price' => $request->input('discounted_price'),
            'image' => $image1,
            'image_2' => $image2,
            'thumbnail' => $thumbnail,
            'display' => $request->input('display'),
        ]);

        $product->categories()->sync($request->input('categories'));
        $product->attributeValues()->sync($request->input('attributes'));

        return $this->redirector->route('admin.products.edit')
            ->with('success', 'Product added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Category             $category
     * @param  \App\Models\Product $product
     * @return ProductResource
     */
    public function show(Product $product)
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
        return $this->view->make('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequest $request
     * @param Category             $category
     * @param  \App\Models\Product $product
     * @return ProductResource
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = [];
        if ($request->file('image') instanceof UploadedFile) {
            $data['image'] = $this->storeFile($request->file('image'));
        }
        if ($request->file('image_2') instanceof UploadedFile) {
            $data['image_2'] = $this->storeFile($request->file('image_2'));
        }
        if ($request->file('thumbnail') instanceof UploadedFile) {
            $data['thumbnail'] = $this->storeFile($request->file('thumbnail'));
        }

        $data = array_merge($data, [
            'name' => $request->input('name'),
            'description' => $request->input('description') ?? '',
            'price' => $request->input('price'),
            'discounted_price' => $request->input('discounted_price'),
            'display' => $request->input('display'),
        ]);

        $product->update($data);

        $product->categories()->sync($request->input('categories'));
        $product->attributeValues()->sync($request->input('attributes'));

        return $this->redirector->back()->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category             $category
     * @param  \App\Models\Product $product
     * @return ProductResource
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        if ($product->delete())
            return new ProductResource($product);
        else
            return $this->response->json([
                'app_message' => "You can't delete this resource!"
            ], 400);
    }
}
