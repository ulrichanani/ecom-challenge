@extends('layouts.app')

@section('content')
    <!--================Product Details Area =================-->
    <section class="product_details_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="product_details_slider">
                        <div id="product_slider" class="rev_slider" data-version="5.3.1.6">
                            <ul>
                                <!-- SLIDE  -->
                                <li data-index="rs-137221490" data-transition="scaledownfrombottom" data-slotamount="7"
                                    data-easein="Power3.easeInOut" data-easeout="Power3.easeInOut"
                                    data-masterspeed="1500"
                                    data-thumb="{{ asset($product->imagePath('image')) }}" data-rotate="0"
                                    data-fstransition="fade" data-fsmasterspeed="1500" data-fsslotamount="7"
                                    data-saveperformance="off" data-title="Ishtar X Tussilago" data-param1="25/08/2015"
                                    data-description="">
                                    <!-- MAIN IMAGE -->
                                    @dump(asset($product->imagePath('image_2')))
                                    <img src="{{ asset($product->imagePath('image')) }}" alt=""
                                         data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat"
                                         data-bgparallax="5" class="rev-slidebg" data-no-retina>
                                    <!-- LAYERS -->
                                </li>
                            @if($product->image_2)
                                <!-- SLIDE  -->
                                    <li data-index="rs-136228343" data-transition="scaledownfrombottom"
                                        data-slotamount="7" data-easein="Power3.easeInOut"
                                        data-easeout="Power3.easeInOut" data-masterspeed="1500"
                                        data-thumb="{{ asset($product->imagePath('image_2')) }}"
                                        data-rotate="0" data-saveperformance="off" data-title="Los Angeles"
                                        data-param1="13/08/2015" data-description="">
                                        <!-- MAIN IMAGE -->
                                        <img src="{{ asset($product->imagePath('image_2')) }}" alt=""
                                             data-bgposition="center center" data-bgfit="cover"
                                             data-bgrepeat="no-repeat" data-bgparallax="5" class="rev-slidebg"
                                             data-no-retina>
                                        <!-- LAYERS -->
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="product_details_text">
                        <h3>{{ $product->name }}</h3>
                        <ul class="p_rating">
                            @for ($i = 0; $i < $product->rating; $i++)
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                            @endfor
                            @for ($i = 0; $i < 5 - $product->rating; $i++)
                                <li><a href="#"><i class="fa fa-star" style="color: #e0e0e0"></i></a></li>
                            @endfor
                        </ul>
                        <div class="add_review">
                            <a href="#">{{ $product->reviews->count() }} Reviews</a>
                            <a id="linkAddReview" href="#nav-add-review">Add your review</a>
                        </div>
                        {{--<h6>Available In <span>Stock</span></h6>--}}
                        <h4>${{ $product->price }}</h4>
                        <p>{{ $product->description }}</p>

                        <!-- ADD PRODUCT TO CART FORM -->
                        <form action="{{ route('cart.add-item', $product) }}" method="post">
                            @csrf
                            @foreach($product->attributesAndValues() as $attributeName => $attributevalues)
                                @if($attributevalues->isNotEmpty())
                                    <div class="p_color">
                                        <h4 class="p_d_title">{{ $attributeName }}</h4>
                                        <select class="form-control" name="attributes[{{ $attributeName }}]">
                                            @foreach ($attributevalues as $attributeValue)
                                                <option>{{ $attributeValue->value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            @endforeach
                            <div class="quantity">
                                <div class="custom">
                                    <button
                                        onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                                        class="reduced items-count" type="button"><i class="icon_minus-06"></i>
                                    </button>
                                    <input type="number" name="qty" id="sst" maxlength="12"
                                           value="{{ $CART->where('product_id', $product->id)->first()->quantity ?? 1 }}"
                                           min="0" title="Quantity:" class="input-text qty">
                                    <button
                                        onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                                        class="increase items-count" type="button"><i class="icon_plus"></i>
                                    </button>
                                </div>
                                <button class="add_cart_btn" href="#" type="submit">Add to cart</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Product Details Area =================-->

    <!--================Product Description Area =================-->
    <section class="product_description_area">
        <div class="container">
            <nav class="tab_menu">
                <div class="nav nav-tabs" id="nav-tab-product" role="tablist">
                    <a class="nav-item nav-link active" id="nav-description-tab" data-toggle="tab"
                       href="#nav-description" role="tab"
                       aria-controls="nav-description" aria-selected="true">Product Description</a>
                    <a class="nav-item nav-link" id="nav-reviews-tab" data-toggle="tab" href="#nav-reviews" role="tab"
                       aria-controls="nav-reviews" aria-selected="false">Reviews</a>
                    <a class="nav-item nav-link" id="nav-add-review-tab" data-toggle="tab" href="#nav-add-review"
                       role="tab"
                       aria-controls="nav-add-review" aria-selected="false">Add review</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-description" role="tabpanel"
                     aria-labelledby="nav-description-tab">
                    <p>{{ $product->description }}</p>
                </div>
                <div class="tab-pane fade" id="nav-reviews" role="tabpanel" aria-labelledby="nav-reviews-tab">
                    @if($reviews->isNotEmpty())
                        @foreach($reviews as $review)
                            <div class="row">
                                <div class="col">
                                    <h4>{{ $review->customer->name }}</h4>
                                    <ul>
                                        @for ($i = 0; $i < $review->rating; $i++)
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        @endfor
                                        @for ($i = 0; $i < 5 - $review->rating; $i++)
                                            <li><a href="#"><i class="fa fa-star" style="color: #e0e0e0"></i></a></li>
                                        @endfor
                                    </ul>
                                    <p>{{ $review->review }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No reviews.</p>
                    @endif
                </div>
                <div class="tab-pane fade" id="nav-add-review" role="tabpanel" aria-labelledby="nav-add-review-tab">
                    @guest
                        <p>
                            You must <a href="{{ route('login') }}">sign in</a> to add a review.
                            If you don't have an account yet, please <a href="{{ route('register') }}">register</a>.
                        </p>
                    @else
                    <!-- ADD REVIEW FORM -->
                        <form action="{{ route('products.addReview', $product) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-12 form-group">
                                    <label for="rating">Rating (Between 0 and 5)</label>
                                    <input name="rating" type="number" class="form-control" min="0" max="5" step="1"
                                           value="{{ $product->reviews->where('customer_id', auth()->id())->first()->rating ?? 0 }}"
                                           required>
                                </div>
                                <div class="col-12 form-group">
                                    <label for="rating">Review</label>
                                    <textarea name="review" type="number" class="form-control" rows="5">{{
                                    $product->reviews->where('customer_id', auth()->id())->first()->review ?? ''
                                    }}</textarea>
                                </div>
                                <div class="col-12">
                                    <input type="submit" value="Save" class="add_cart_btn">
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!--================End Product Details Area =================-->
@endsection

@section('page-js')
    <script>
        $('#linkAddReview').click(e => {
            $('#nav-tab-product a[href="#nav-add-review"]').tab('show')
            $('html').animate({
                scrollTop: $('#nav-tabContent').offset().top
            }, 0);
        })
    </script>
@stop
