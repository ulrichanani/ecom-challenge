<!--================Menu Area =================-->
<header class="shop_header_area carousel_menu_area">
    <div class="carousel_top_header row m0">
        <div class="container">
            <div class="carousel_top_h_inner">
                <div class="float-md-left">
                    <div class="top_header_left">
                        <div class="selector">
                            {{--<select class="language_drop" name="countries" id="countries" style="width:300px;">
                                <option value='yt' data-image="/img/icon/flag-1.png" data-imagecss="flag yt"
                                        data-title="English">English
                                </option>
                                <option value='yu' data-image="/img/icon/flag-1.png" data-imagecss="flag yu"
                                        data-title="Bangladesh">Bangla
                                </option>
                                <option value='yt' data-image="/img/icon/flag-1.png" data-imagecss="flag yt"
                                        data-title="English">English
                                </option>
                                <option value='yu' data-image="/img/icon/flag-1.png" data-imagecss="flag yu"
                                        data-title="Bangladesh">Bangla
                                </option>
                            </select>--}}
                        </div>
                        {{--<select class="selectpicker usd_select">
                            <option>USD</option>
                            <option>$</option>
                            <option>$</option>
                        </select>--}}
                    </div>
                </div>
                <div class="float-md-right">
                    <div class="top_header_middle">
                        <a href="#"><i class="fa fa-phone"></i> Call Us: <span>+84 987 654 321</span></a>
                        <a href="#"><i class="fa fa-envelope"></i> Email: <span>support@yourdomain.com</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="carousel_menu_inner">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="/"><img src="{{ asset('storage/images/tshirtshop.png') }}" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>

                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <?php $DEPARTMENTS_CHUNKS = $DEPARTMENTS->chunk(3) ?>
                        @foreach($DEPARTMENTS_CHUNKS[0] as $k => $department)
                            <li class="nav-item dropdown submenu">
                                <a class="nav-link dropdown-toggle" href="{{ route('departments.show', $department) }}"
                                   role="button" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    {{ $department->name }} <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item"><a class="nav-link"
                                                            href="{{ route('departments.show', $department) }}">
                                            All Products</a></li>
                                    @foreach($department->categories as $category)
                                        <li class="nav-item"><a class="nav-link"
                                                                href="{{ route('categories.show', $category) }}">
                                                {{ $category->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                        @if($DEPARTMENTS_CHUNKS[1]->count() > 0)
                            <li class="nav-item dropdown submenu">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    Other Departments <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach($DEPARTMENTS_CHUNKS[1] as $k => $department)
                                        <li class="nav-item"><a class="nav-link"
                                                                href="{{ route('departments.show', $department) }}">
                                                {{ $department->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    </ul>
                    <ul class="navbar-nav justify-content-end">
                        <li class="search_icon"><a href="/search"><i class="icon-magnifier icons"></i></a></li>
                        <li class="user_icon"><a href="/user"><i class="icon-user icons"></i></a></li>
                        <li class="cart_cart"><a href="/cart" id="cartCount" data-cart-count="{{ $CART->count() }}">
                                <i class="icon-handbag icons"></i>
                                {{ $CART->count() }}
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>
<!--================End Menu Area =================-->
