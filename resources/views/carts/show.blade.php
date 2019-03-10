@extends('layouts.app')

@section('content')
    <!--================Categories Banner Area =================-->
    <section class="solid_banner_area">
        <div class="container">
            <div class="solid_banner_inner">
                <h3>shopping cart</h3>
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
                    <div class="col-lg-12">
                        <div class="cart_product_list">
                            {{--<h3 class="cart_single_title">Discount Cupon</h3>--}}
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
                    <div class="offset-8 col-lg-4">
                        <div class="total_amount_area">
                            <div class="cart_totals">
                                <div class="cart_total_inner">
                                    <ul>
                                        <li><a href="#"><span>Cart Subtotal</span> ${{ $CART->sum('subTotal') }}
                                            </a>
                                        </li>
                                        <li><a href="#"><span>Totals</span> ${{ $CART->sum('subTotal') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="total_amount_area">
                            <div class="cart_totals">
                                <div class="text-right">
                                    <button type="submit" form="cartUpdateForm"
                                            class="btn btn-primary update_btn">Update cart
                                    </button>
                                    <a href="{{ \Session::get('PRODUCTS_PAGE') }}"
                                       class="btn btn-primary update_btn">Continue shopping
                                    </a>
                                    <button type="submit" class="btn btn-primary checkout_btn ml-0">Proceed to
                                        checkout
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!--================End Shopping Cart Area =================-->

    <section class="shopping_cart_area p_100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cart_product_list">
                        <h3 class="cart_single_title">Saved Products</h3>
                        @if($savedItems->isNotEmpty())
                            <div class="table-responsive-md">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">product</th>
                                        <th scope="col">options</th>
                                        <th scope="col">price</th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($savedItems as $savedItem)
                                        <tr>
                                            <th scope="row">
                                                <img src="img/icon/close-icon.png" alt="" class="btn-delete"
                                                     data-delete-url="{{ route('cart.remove-item', $savedItem->id) }}">
                                            </th>
                                            <td>
                                                <div class="media">
                                                    <div class="d-flex">
                                                        <a href="{{ route('products.show', $savedItem->product_id) }}">
                                                            <img
                                                                src="{{ $savedItem->product->imagePath('thumbnail') }}"
                                                                alt="">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <a href="{{ route('products.show', $savedItem->product_id) }}">
                                                            <h4>{{ $savedItem->product->name }}</h4>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $savedItem->attributes }}</td>
                                            <td><p>${{ $savedItem->product->realPrice }}</p></td>
                                            <td><p>
                                                    <a href="{{ route('cart.move-to-cart', $savedItem->id) }}"
                                                       data-submit-form="form-submit">
                                                        Move to cart</a>
                                                    <br>
                                                    <a href="{{ route('cart.remove-item', $savedItem->id) }}"
                                                       data-submit-form="form-delete">
                                                        Remove
                                                    </a>
                                                </p></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center mb-5">
                                <em><h5>No saved products yet ...</h5></em>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>


    <form id="form-submit" action="" method="post" style="display: none;">
        @csrf
    </form>
@endsection
