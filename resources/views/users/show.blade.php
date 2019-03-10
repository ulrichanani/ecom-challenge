@extends('layouts.app')

@section('content')
    <!--================Categories Banner Area =================-->
    <section class="solid_banner_area">
        <div class="container">
            <div class="solid_banner_inner">
                <h3>My space</h3>
                {{--<ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="shopping-cart.html">Shopping cart</a></li>
                </ul>--}}
            </div>
        </div>
    </section>
    <!--================End Categories Banner Area =================-->

    <section class="product_description_area">
        <div class="container">
            <nav class="tab_menu">
                <div class="nav nav-tabs" id="nav-tab-product" role="tablist">
                    {{--<a class="nav-item nav-link active" id="nav-description-tab" data-toggle="tab"
                       href="#nav-description" role="tab"
                       aria-controls="nav-description" aria-selected="true">My orders</a>--}}
                    <a class="nav-item nav-link active" id="nav-reviews-tab" data-toggle="tab" href="#nav-reviews" role="tab"
                       aria-controls="nav-reviews" aria-selected="false">Shipping Address Information</a>
                    {{--<a class="nav-item nav-link" id="nav-add-review-tab" data-toggle="tab" href="#nav-add-review"
                       role="tab"
                       aria-controls="nav-add-review" aria-selected="false">Others</a>--}}
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                {{--<div class="tab-pane fade show active" id="nav-description" role="tabpanel"
                     aria-labelledby="nav-description-tab">
                    <p>Desc</p>
                </div>--}}
                <div class="tab-pane fade show active" id="nav-reviews" role="tabpanel" aria-labelledby="nav-reviews-tab">
                    @include('users.edit')
                </div>
                {{--<div class="tab-pane fade" id="nav-add-review" role="tabpanel" aria-labelledby="nav-add-review-tab">
                    Hi
                </div>--}}
            </div>
        </div>
    </section>


    <form id="form-submit" action="" method="post" style="display: none;">
        @csrf
    </form>
@endsection
