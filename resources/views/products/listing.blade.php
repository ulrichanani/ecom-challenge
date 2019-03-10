@extends('layouts.app')

@section('content')
    <!--================Categories Banner Area =================-->
    <section class="categories_banner_area">
        <div class="container">
            <div class="c_banner_inner" style="color: white">
                Department : <h3>{{ $currentDepartment->name }}</h3>
                @isset($currentCategory)
                    Category : <h4>{{ $currentCategory->name}}</h4>
                @endif
                {{--<ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Shop</a></li>
                    <li class="current"><a href="#">Shop Grid with Left Sidebar</a></li>
                </ul>--}}
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
                        @if($products->isNotEmpty())
                            <div class="showing_fillter">
                                <div class="row m0">
                                    <div class="first_fillter">
                                        <h4>Showing {{ $products->firstItem() }} to {{ $products->lastItem() }}
                                            of {{ $products->total() }} total</h4>
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
                        <div class="categories_product_area">
                            <div class="row">
                                @if($products->isNotEmpty())
                                    @foreach($products as $product)
                                        <a href="{{ route('products.show', $product) }}">
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="l_product_item">
                                                    <div class="l_p_img">
                                                        <img src='{{ $product->imagePath("image") }}'
                                                             class="img-fluid" alt="" width="270" height="320">
                                                        {{--<h5 class="new">New</h5>--}}
                                                    </div>
                                                    <div class="l_p_text">
                                                        <ul>
                                                            {{--<li class="p_icon"><a href="#"><i class="icon_piechart"></i></a>
                                                            </li>--}}
                                                            <li><a class="add_cart_btn" href="{{ route('products.show', $product) }}">More infos</a></li>
                                                            {{--<li class="p_icon"><a href="#"><i class="icon_heart_alt"></i></a>--}}
                                                            </li>
                                                        </ul>
                                                        <h4>{{ $product->name }}</h4>
                                                        <h5>
                                                            @if($product->discounted_price > 0)
                                                                <del>${{ $product->price }}</del>
                                                                ${{ $product->discounted_price }}
                                                            @else
                                                                ${{ $product->price }}
                                                            @endif
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                @else
                                    <div class="col text-center">
                                        <h4 class="mt-3">
                                            <em>There's no products in this category yet, please come later.</em>
                                        </h4>
                                    </div>
                                @endif
                            </div>
                            <nav aria-label="Page navigation example" class="pagination_area">
                                <ul class="pagination">
                                    {{ $products->links() }}
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
