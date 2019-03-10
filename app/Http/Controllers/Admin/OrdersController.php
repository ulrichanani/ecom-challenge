<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrdersCollection;
use App\Models\Order;
use App\Models\ShippingRegion;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\ResponseFactory;

class OrdersController extends Controller
{
    private $view;
    private $response;
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

    /**
     * Display the resource page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$orders = Order::orderBy('created_on')->with(['customer', 'shipping'])->paginate(15);
        return new OrdersCollection($orders);*/
        return $this->view->make('admin.orders.index');
    }

    /**
     * Get the listing of the resource.
     *
     * @return OrdersCollection
     */
    public function list()
    {
        $orders = Order::orderBy('created_on', 'desc')->with(['customer', 'shipping'])->paginate(15);
        return new OrdersCollection($orders);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $order = Order::where('order_id', $id)->with(['customer', 'shipping'])->first();
        $order->shipping_region = ShippingRegion::find($order->shipping->shipping_region_id);

        return $this->view->make('admin.orders.edit', [
            'order' => $order,
            'customer' => $order->customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Order                     $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->status = $request->input('status');
        $order->shipped_on = Carbon::parse($request->input('shipped_on'));
        $order->comments = $request->input('comments');
        $order->save();

        return $this->redirect->back()->with('success', 'Order infos updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
