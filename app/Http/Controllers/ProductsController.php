<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Support\Facades\Cookie;

class ProductsController extends Controller
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
     * @param Product $product
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Product $product)
    {
        $product->rating = round($product->reviews()->average('rating'), 0, PHP_ROUND_HALF_UP);

        return $this->view->make('products.show', compact('product'));
    }

    public function addReview(Request $request, Product $product)
    {
        if (!$request->input('rating'))
            return back()->with('error', 'You must submit a rating for your review.');

        Review::updateOrCreate([
            'product_id' => $product->id,
            'customer_id' => auth()->id(),
        ], [
            'rating' => (int)$request->input('rating') % 5,
            'review' => $request->input('review') ?? '',
            'created_on' => now(),
        ]);

        return back()->with('success', 'Review saved.');
    }
}
