<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;

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
        $reviews = $product->reviews()->with('customer')->get();

        return $this->view->make('products.show', compact('product', 'reviews'));
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

    public function search(Request $request)
    {
        $query = $request->input('query');
        $keywords = explode(' ', $query);
        $keywords = array_filter($keywords, function ($value) {
            return !empty($value) AND strlen($value) > 1;
        });
        $searchInBlock = (bool) $request->input('search_block');

        if (empty($keywords)) {
            $products = null;
            $query = '';
        } elseif (!empty($searchInBlock)) {
            $products = Product::where('name', 'LIKE', "%" . $query . "%")
                ->orWhere('description', 'LIKE', "%" . $query . "%")->paginate(15);
        } else {
            $firstWord = array_slice($keywords, 0, 1)[0];
            $qb = Product::where('name', 'LIKE', "%" . $firstWord . "%")
                ->orWhere('description', 'LIKE', "%" . $firstWord . "%");

            foreach ($keywords as $keyword) {
                $qb->orWhere('name', 'LIKE', "%$keyword%")
                    ->orWhere('description', 'LIKE', "%" . $firstWord . "%");
            }
            $products = $qb->paginate(15);
        }

        return $this->view->make('products.search', [
            'products' => $products,
            'query' => $query,
            'searchInBlock' => $searchInBlock
        ]);
    }
}
