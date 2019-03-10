@extends('layouts.app')

@section('content')
    <!--================Categories Banner Area =================-->
    <section class="categories_banner_area">
        <div class="container">
            <div class="c_banner_inner" style="color: white">
                Search results for : <h5>{{ $query }}</h5>
            </div>
        </div>
    </section>
    <!--================End Categories Banner Area =================-->

    <!--================Categories Product Area =================-->
    <section class="categories_product_main p_80">
        <div class="container">
            <div class="categories_main_inner">
                <div class="row row_disable">
                    <div class="col-lg-9 float-md-right">
                        @if($products AND $products->isNotEmpty())
                            <div class="showing_fillter">
                                <div class="row m0">
                                    <div class="first_fillter">
                                        <h4>Showing {{ $products->firstItem() }} to {{ $products->lastItem() }}
                                            of {{ $products->total() }} total</h4>
                                    </div>
                                    <div class="col text-right">
                                        <nav aria-label="" class="pagination_area text-right mt-0">
                                            <ul class="pagination">
                                                {{ $products->appends(['query' => $query])->links() }}
                                            </ul>
                                        </nav>
                                    </div>

                                    {{--<div class="secand_fillter">
                                        <h4>SORT BY :</h4>
                                        <select class="selectpicker">
                                            <option>Name</option>
                                            <option>Name 2</option>
                                            <option>Name 3</option>
                                        </select>
                                    </div>
                                    <div class="third_fillter">
                                        <h4>Show : </h4>
                                        <select class="selectpicker">
                                            <option>09</option>
                                            <option>10</option>
                                            <option>10</option>
                                        </select>
                                    </div>
                                    <div class="four_fillter">
                                        <h4>View</h4>
                                        <a class="active" href="#"><i class="icon_grid-2x2"></i></a>
                                        <a href="#"><i class="icon_grid-3x3"></i></a>
                                    </div>--}}
                                </div>
                            </div>
                        @endif
                        <div class="c_product_grid_details">
                            @if($products AND $products->isNotEmpty())
                                @foreach($products as $product)
                                    <div class="c_product_item">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6">
                                                <div class="c_product_img">
                                                    <a
                                                        href="{{ route('products.show', $product) }}">
                                                        <img class="img-fluid"
                                                             width="270" height="320"
                                                             src="{{ asset($product->imagePath("image")) }}" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-md-6">
                                                <div class="c_product_text">
                                                    <h3>{{ $product->name }}</h3>
                                                    <h5>
                                                        @if($product->discounted_price > 0)
                                                            <del class="old-price">${{ $product->price }}</del>
                                                            ${{ $product->discounted_price }}
                                                        @else
                                                            ${{ $product->price }}
                                                        @endif
                                                    </h5>
                                                    <p>{{ str_limit($product->description, 300) }}</p>
                                                    <ul class="c_product_btn">
                                                        <li><a class="add_cart_btn"
                                                               href="{{ route('products.show', $product) }}">More
                                                                infos</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col text-center">
                                    <h4 class="mt-3">
                                        <em>No matching products ...</em>
                                    </h4>
                                </div>
                            @endif
                            <nav aria-label="Page navigation" class="pagination_area">
                                <ul class="pagination">
                                    {{ $products ? $products->appends(['query' => $query])->links() : '' }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                    @include('products.sidebar')
                </div>
            </div>
        </div>
    </section>
    <!--================End Categories Product Area =================-->
@endsection
