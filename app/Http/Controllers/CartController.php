<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProductToCartRequest;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;

class CartController extends Controller
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

    public function index()
    {
        $savedItems = ShoppingCart::current()->saved()->get();

        return $this->view->make('carts.show', compact('savedItems'));
    }

    public function addItem(AddProductToCartRequest $request, Product $product)
    {
        $cartId = ShoppingCart::getCartId();

        $data = [];
        $data["quantity"] = $request->input('qty');
        $data["buy_now"] = true;

        $attributes = $request->input('attributes');
        $formattedAttributes = implode('/', array_keys($attributes));
        $formattedAttributes .= ' : ' . implode('/', $attributes);

        ShoppingCart::current()->updateOrCreate([
            'cart_id' => $cartId,
            'product_id' => $product->id,
            'attributes' => $formattedAttributes
        ], $data);
        /*ShoppingCart::where("cart_id", $cart_id)
            ->where("product_id", $product->product_id)->update($data);*/

        return redirect()->back()
            ->with('success', 'Product successfully added to the shopping cart.');
    }

    public function removeItem($itemId)
    {
        ShoppingCart::current()->where('item_id', $itemId)->delete();

        return redirect()->back()
            ->with('success', 'Product successfully removed from the shopping cart.');
    }

    public function update(Request $request)
    {
        $items = $request['items'];

        foreach ($items as $itemId => $itemInfos) {
            if (!empty($itemInfos['remove'])) {
                ShoppingCart::current()->where('item_id', $itemId)->delete();
            } else {
                ShoppingCart::current()->where('item_id', $itemId)->update([
                    'quantity' => $itemInfos['quantity']
                ]);
            }
        }

        return redirect()->back()
            ->with('success', 'The shopping cart was successfully updated.');
    }

    public function saveForLater($itemId)
    {
        ShoppingCart::current()->where('item_id', $itemId)->update([
            'buy_now' => false
        ]);

        return redirect()->back()
            ->with('success', 'The shopping cart was successfully updated.');
    }

    public function moveToCart($itemId)
    {
        ShoppingCart::current()->where('item_id', $itemId)->update([
            'buy_now' => true
        ]);

        return redirect()->back()
            ->with('success', 'The shopping cart was successfully updated.');
    }
}
