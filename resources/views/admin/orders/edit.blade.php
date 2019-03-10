@extends('admin.layouts.app')

@section('title', 'Order Infos')
@section('desc', '')

@section('content')

    {{--<order-edit-component
        :order_id="{{ $order_id }}"></order-edit-component>--}}

    <div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary mb-2">
            <i class="fa fa-arrow-left"></i> Back</a>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Main content -->
            <section class="content">
                <div class="row mb-5">
                    <div class="col-12">
                        {!! Form::model($order, [
                        'url' => route('admin.orders.update', $order),
                         'method' => 'put'
                         ]) !!}

                        <table class="table">
                            <tr>
                                <th>Reference :</th>
                                <td>{{ $order->reference }}</td>
                            </tr>
                            <tr>
                                <th>Status :</th>
                                <td>
                                    <select name="status" id="" class="form-control">
                                        <option value="1"{{ $order->status === 1 ? ' selected' : '' }}>Not Shipped
                                        </option>
                                        <option value="2"{{ $order->status === 2 ? ' selected' : '' }}>Shipped
                                        </option>
                                        <option value="3"{{ $order->status === 3 ? ' selected' : '' }}>Cancelled
                                        </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Customer :</th>
                                <td>{{ $order->customer->name }}</td>
                            </tr>
                            <tr>
                                <th>Total Amount :</th>
                                <td>{{ $order->total_amount }}</td>
                            </tr>
                            <tr>
                                <th>Created On :</th>
                                <td>{{ $order->created_on }}</td>
                            </tr>
                            <tr>
                                <th>Shipped on :</th>
                                <td>
                                    {!! Form::date('shipped_on', null, [
                                    'class' => 'form-control'
                                    ]) !!}
                                </td>
                            </tr>
                            <tr>
                                <th>Auth Code :</th>
                                <td>{{ $order->auth_code }}</td>
                            </tr>
                            <tr>
                                <th>Shipping Option :</th>
                                <td>{{ $order->shipping_region->shipping_region }} -
                                    {{ $order->shipping->shipping_type }}
                                </td>
                            </tr>
                            <tr>
                                <th>Shipping Address :</th>
                                <td>{{ $customer->address_2 }}</td>
                            </tr>
                            <tr>
                                <th>Comments :</th>
                                <td>
                                    {!! Form::textarea('comments', null, ['class' => 'form-control']) !!}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <button type="sumbit" class="btn btn-primary">Save changes</button>
                                </th>
                                <td></td>
                            </tr>
                        </table>
                        {!! Form::close() !!}
                    </div>

                    <div class="col-12 mt-5">
                        <h3>Products</h3>
                    </div>

                    <div class="col-12 mt-5">
                        <table class="table">
                            <thead>
                            <th>Name</th>
                            <th>Attributes</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                            <th class="actions"></th>
                            </thead>
                            <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->attributes }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->unit_cost }}</td>
                                    <td>{{ $item->subtotal }}</td>
                                    <td class="actions">
                                        <div>
                                            <a class="btn btn-primary btn-sm mb-1"
                                            href="{{ route('products.show', $item->product_id) }}">
                                                Show product</a>
                                         </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="4">Shipping</th>
                                <td>{{ $order->shipping->shipping_cost }}</td>
                            </tr>
                            <tr>
                                <th colspan="4">Total</th>
                                <td>{{ $order->total_amount }}</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="col-12 mt-5">
                        <h3>Customer information</h3>
                    </div>

                    <div class="col-12 mt-5">
                        <table class="table">
                            <tr>
                                <th>Name :</th>
                                <td>{{ $customer->name }}</td>
                            </tr>
                            <tr>
                                <th>email :</th>
                                <td>{{ $customer->email }}</td>
                            </tr>
                            <tr>
                                <th>Address :</th>
                                <td>{{ $customer->address_1 }}</td>
                            </tr>
                            <tr>
                                <th>City :</th>
                                <td>{{ $customer->city }}</td>
                            </tr>
                            <tr>
                                <th>Region :</th>
                                <td>{{ $customer->region }}</td>
                            </tr>
                            <tr>
                                <th>Postal code :</th>
                                <td>{{ $customer->postal_code }}</td>
                            </tr>
                            <tr>
                                <th>Country :</th>
                                <td>{{ $customer->country }}</td>
                            </tr>
                            <tr>
                                <th>Mobile Phone :</th>
                                <td>{{ $customer->mobile_phone }}</td>
                            </tr>
                            <tr>
                                <th>Day Phone :</th>
                                <td>{{ $customer->day_phone }}</td>
                            </tr>
                            <tr>
                                <th>Evening Phone :</th>
                                <td>{{ $customer->eve_phone }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection
