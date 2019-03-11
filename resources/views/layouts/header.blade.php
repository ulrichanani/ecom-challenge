<!--================Menu Area =================-->
<header class="shop_header_area carousel_menu_area">
    <div class="carousel_top_header row m0">
        <div class="container">
            <div class="carousel_top_h_inner">
                <div class="float-md-left">
                    <div class="top_header_left">
                        <i class="fa fa-phone"></i> Call Us: <span>+84 987 654 321</span> |
                        <i class="fa fa-envelope"></i> Email: <span>support@yourdomain.com</span>
                    </div>
                </div>
                <div class="float-md-right">
                    <div class="top_header_middle">
                        <strong>
                        @guest
                            <a href="{{ route('login') }}">
                                <i class="fa fa-sign-in"></i> Login
                            </a>
                            <a href="{{ route('register') }}">
                                <i class="fa fa-sign-out"></i> Register
                            </a>
                        @else
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fa fa-home"></i> Shop Admin
                            </a>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('form-logout').submit()">
                                <i class="fa fa-sign-out"></i> Logout
                            </a>
                        @endif
                        </strong>
                    </div>
                    <form action="/logout" method="post" id="form-logout" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="carousel_menu_inner">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('storage/images/tshirtshop.png') }}" alt=""></a>
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
                        @if(isset($DEPARTMENTS_CHUNKS[1]) && ($DEPARTMENTS_CHUNKS[1]->count() > 0))
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
                        {{--<li class="search_icon"><a href="/search"><i class="icon-magnifier icons"></i></a></li>--}}
                        @auth
                            <li class="user_icon"><a href="{{ route('user') }}" data-toggle="tooltip"
                                                     title="@auth My space @else Login/Register @endif">
                                    <i class="icon-user icons"></i></a></li>
                        @endauth
                        <li class="cart_cart"><a href="{{ route('cart') }}" id="cartCount" data-cart-count="{{ $CART->count() }}">
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
