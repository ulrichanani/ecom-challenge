<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProductToCartRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\ShippingRegion;
use App\Models\ShoppingCart;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\ResponseFactory;

class CartController extends Controller
{
    private $view;
    private $response;
    /**
     * @var Redirector
     */
    private $redirect;

    /**
     * Constructor.
     * @param ViewFactory     $view
     * @param ResponseFactory $response
     * @param Redirector      $redirect
     */
    public function __construct(ViewFactory $view, ResponseFactory $response, Redirector $redirect)
    {
        $this->view = $view;
        $this->response = $response;
        $this->redirect = $redirect;
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

    public function checkout(Request $request)
    {
        if(ShoppingCart::current()->buyNow()->count() === 0)
            return $this->redirect->back()->with('warning', 'Your shopping cart is empty');

        $shippingRegions = ShippingRegion::all();
        $shippingTypes = Shipping::all();
        $user = $request->user();

        return $this->view->make('carts.checkout', compact('user', 'shippingRegions', 'shippingTypes'));
    }

    public function order(StoreOrderRequest $request)
    {
        $cartItems = ShoppingCart::current()->buyNow()->with('product')->get();
        if($cartItems->count() === 0)
            return $this->redirect->back()->with('warning', 'Your shopping cart is empty');

        $data = $request->validated();
        $request->user()->update($data);

        $shipping = Shipping::findOrFail($request->input('shipping_id'));
        $data['total_amount'] = $cartItems->sum('subTotal') + (int)$shipping->shipping_cost;
        $data['status'] = Order::STATUSES['not_shipped'];
        $data['customer_id'] = $request->user()->id;
        $data['auth_code'] = str_random('5');
        $data['reference'] = 'REF' . (Order::max('order_id') + 1001);
        $data['tax_id'] = 1;

        $order = Order::create($data);

        foreach ($cartItems as $item) {
            $product = $item->product;
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_name' => $product->name,
                'attributes' => $item->attributes,
                'quantity' => $item->quantity,
                'unit_cost' => $product->realPrice,
            ]);
        }

        // Sending notification mail
        try {
            $request->user()->notify(new OrderCreatedNotification($order));
        } catch (\Exception $e) {}

        // Delete buyed cart items
        ShoppingCart::current()->buyNow()->delete();

        return $this->redirect->route('cart')->with('success', 'Your order was successfully registered');
    }
}
