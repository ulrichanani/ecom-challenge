@extends('layouts.app')

@section('content')
    <!--================Categories Banner Area =================-->
    <section class="solid_banner_area">
        <div class="container">
            <div class="solid_banner_inner">
                <h3>Checkout</h3>
                {{--<ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="shopping-cart.html">Shopping cart</a></li>
                </ul>--}}
            </div>
        </div>
    </section>
    <!--================End Categories Banner Area =================-->

    <!--================Shopping Cart Area =================-->
    @if($CART->isEmpty())
        <section class="emty_cart_area p_100">
            <div class="container">
                <div class="emty_cart_inner">
                    <i class="icon-handbag icons"></i>
                    <h3>Your Cart is Empty</h3>
                    <h4>back to <a href="{{ \Session::get('PRODUCTS_PAGE') }}">shopping</a></h4>
                </div>
            </div>
        </section>
    @else
        <section class="shopping_cart_area p_100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12" id="shoppingCart" style="display: none;">
                        <div class="cart_product_list">
                            <div class="table-responsive-md">
                                <form action="{{ route('cart.update') }}" method="post" name="cartUpdateForm"
                                      id="cartUpdateForm">
                                    @csrf
                                    @method('put')
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">product</th>
                                            <th scope="col">options</th>
                                            <th scope="col">price</th>
                                            <th scope="col">quantity</th>
                                            <th scope="col">remove</th>
                                            <th scope="col">total</th>
                                            <th scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($CART as $cartItem)
                                            <tr>
                                                <th scope="row">
                                                    <img src="img/icon/close-icon.png" alt="" class="btn-delete"
                                                         data-delete-url="{{ route('cart.remove-item', $cartItem->id) }}">
                                                </th>
                                                <td>
                                                    <div class="media">
                                                        <div class="d-flex">
                                                            <a href="{{ route('products.show', $cartItem->product_id) }}">
                                                                <img
                                                                    src="{{ $cartItem->product->imagePath('thumbnail') }}"
                                                                    alt="">
                                                            </a>
                                                        </div>
                                                        <div class="media-body">
                                                            <a href="{{ route('products.show', $cartItem->product_id) }}">
                                                                <h4>{{ $cartItem->product->name }}</h4>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $cartItem->attributes }}</td>
                                                <td><p>${{ $cartItem->product->realPrice }}</p></td>
                                                <td><input type="number"
                                                           name="items[{{$cartItem->id}}][quantity]"
                                                           min="1"
                                                           value="{{ $cartItem->quantity }}"></td>
                                                <td><input type="checkbox"
                                                           name="items[{{ $cartItem->id }}][remove]">
                                                </td>
                                                <td><p>${{ $cartItem->subTotal }}</p></td>
                                                <td><p><a href="{{ route('cart.save-for-later', $cartItem) }}"
                                                          data-submit-form="form-submit" data-submit-noconfirm>
                                                            Save for later</a></p></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        {!! Form::model($user, ['route' => 'order', 'method' => 'post', 'id' => "placeOrderForm"]) !!}

                        <div class="row">

                            <div class="col-8">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="shipping_region" class="control-label">Shipping Region
                                            <span class="text-danger">*</span></label>
                                        {!! Form::select('shipping_region_id', \App\Models\ShippingRegion::getAllIdsAndNames(), null, [
                                        'class' => 'form-control' . ($errors->has('shipping_region_id') ? ' is-invalid' : ''),
                                        'id' => 'shipping_region_id',
                                        'required'
                                        ]) !!}
                                        @if ($errors->has('shipping_region_id'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('shipping_region_id') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="shipping_id" class="control-label">Shipping Type
                                            <span class="text-danger">*</span></label>
                                        <select name="shipping_id" id="shipping_id"
                                                class="form-control{{ $errors->has('shipping_id') ? ' is-invalid' : '' }}">
                                            <option value="">Please select</option>
                                            @foreach(\App\Models\Shipping::all() as $option)
                                                <option value="{{ $option->id }}"
                                                        data-region-id="{{ $option->shipping_region_id }}"
                                                        data-cost="{{ $option->shipping_cost }}">
                                                    {{ $option->shipping_type }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('shipping_id'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('shipping_id') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="total_amount_area">
                                    <div class="cart_totals">
                                        <div class="cart_total_inner">
                                            <ul>
                                                <li><a href="#"><span>Cart Subtotal</span>
                                                        <span class="cartTotals"
                                                              id="cartSubtotal">{{ $CART->sum('subTotal') }}</span></a>
                                                </li>
                                                <li><a href="#"><span>Shipping</span>
                                                        <span class="cartTotals" id="shippingAmount">Free</span></a>
                                                </li>
                                                <li><a href="#"><span>Totals</span>
                                                        <span class="cartTotals"
                                                              id="cartTotal">{{ $CART->sum('subTotal') }}</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <h3 class="cart_single_title">Delivery information</h3>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="name" class="control-label">Name
                                    <span class="text-danger">*</span></label>
                                {!! Form::text('name', null, [
                                'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),
                                'required'
                                ]) !!}
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="address_2" class="control-label">Address
                                    <span class="text-danger">*</span></label>
                                {!! Form::text('address_2', null, [
                                'class' => 'form-control' . ($errors->has('address_2') ? ' is-invalid' : ''),
                                'required'
                                ]) !!}
                                @if ($errors->has('address_2'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address_2') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="city" class="control-label">City
                                    <span class="text-danger">*</span></label>
                                {!! Form::text('city', null, [
                                'class' => 'form-control' . ($errors->has('city') ? ' is-invalid' : ''),
                                'required'
                                ]) !!}
                                @if ($errors->has('city'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="country" class="control-label">Country
                                    <span class="text-danger">*</span></label>
                                {!! Form::text('country', null, [
                                'class' => 'form-control' . ($errors->has('country') ? ' is-invalid' : ''),
                                'required'
                                ]) !!}
                                @if ($errors->has('country'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="postal_code" class="control-label">Postal Code
                                    <span class="text-danger">*</span></label>
                                {!! Form::text('postal_code', null, [
                                'class' => 'form-control' . ($errors->has('postal_code') ? ' is-invalid' : ''),
                                'required'
                                ]) !!}
                                @if ($errors->has('postal_code'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('postal_code') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="mob_phone" class="control-label">Phone
                                    <span class="text-danger">*</span></label>
                                {!! Form::text('mob_phone', null, [
                                'class' => 'form-control' . ($errors->has('mob_phone') ? ' is-invalid' : ''),
                                'required'
                                ]) !!}
                                @if ($errors->has('mob_phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mob_phone') }}</strong>
                                    </span>
                                @endif
                            </div>

                            {{--<div class="col-12 mt-3">
                                <h3 class="cart_single_title">Payment information</h3>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="cart_holder_name" class="control-label">Cartholder's name
                                    <span class="text-danger">*</span></label>
                                {!! Form::text('cart_holder_name', $user->name, [
                                'class' => 'form-control' . ($errors->has('cart_holder_name') ? ' is-invalid' : ''),
                                'required'
                                ]) !!}
                                @if ($errors->has('cart_holder_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('cart_holder_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="credit_card" class="control-label">Credit cart number
                                    <span class="text-danger">*</span></label>
                                {!! Form::text('credit_card', null, [
                                'class' => 'form-control' . ($errors->has('credit_card') ? ' is-invalid' : ''),
                                'required'
                                ]) !!}
                                @if ($errors->has('credit_card'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('credit_card') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="credit_card_cvv" class="control-label">CVV / CVC
                                    <span class="text-danger">*</span></label>
                                {!! Form::text('credit_card_cvv', null, [
                                'class' => 'form-control' . ($errors->has('credit_card_cvv') ? ' is-invalid' : ''),
                                'required'
                                ]) !!}
                                @if ($errors->has('credit_card_cvv'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('credit_card_cvv') }}</strong>
                                    </span>
                                @endif
                            </div>--}}
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="total_amount_area">
                        <div class="cart_totals">
                            <div class="text-right">
                                <a href="{{ \Session::get('PRODUCTS_PAGE') }}"
                                   class="btn btn-primary update_btn">Continue shopping
                                </a>
                                <button type="submit"
                                        form="placeOrderForm" id="placeOrder"
                                        class="btn btn-primary checkout_btn ml-0">Place order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    @endif


    <form id="form-submit" action="" method="post" style="display: none;">
        @csrf
    </form>
@endsection
