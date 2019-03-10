<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar"
                                        src="{{ asset('admin-assets/imgs/avatar_48dp.png') }}" alt="User Image">
        <div>
            <p class="app-sidebar__user-name">{{ config('app.name') }}</p>
            <p class="app-sidebar__user-designation">Administration</p>
        </div>
    </div>
    <ul class="app-menu">
        <li><a class="app-menu__item" href="{{ route('admin.dashboard') }}"><i
                    class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>


        <!-- Products -->
        <li><a class="app-menu__item" href="{{ route('admin.products.index') }}"><i
                    class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Products</span></a></li>


        <!-- Departments -->
        <li><a class="app-menu__item" href="{{ route('admin.departments.index') }}"><i
                    class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Departments</span></a></li>


        <!-- Attributes -->
        <li><a class="app-menu__item" href="{{ route('admin.attributes.index') }}"><i
                    class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Attributes</span></a></li>


        <!-- Orders -->
        <li><a class="app-menu__item" href="{{ route('admin.orders.index') }}"><i
                    class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Orders</span></a></li>
    </ul>
</aside>
